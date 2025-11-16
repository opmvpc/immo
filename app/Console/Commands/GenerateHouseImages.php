<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\House;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GenerateHouseImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'houses:generate-images
                            {--house= : ID d\'une maison spécifique}
                            {--force : Régénérer même si des images existent déjà}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère des images pour les maisons via OpenRouter AI';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $apiKey = config('services.openrouter.api_key');

        if (!$apiKey) {
            $this->error('❌ OPENROUTER_API_KEY non configurée dans .env');
            $this->info('💡 Ajoutez: OPENROUTER_API_KEY=votre_clé_api');

            return self::FAILURE;
        }

        // Récupérer les maisons à traiter
        $query = House::query()->with('images');

        if ($houseId = $this->option('house')) {
            $query->where('id', $houseId);
        }

        if (!$this->option('force')) {
            // Ne traiter que les maisons sans images
            $query->doesntHave('images');
        }

        $houses = $query->get();

        if ($houses->isEmpty()) {
            $this->info('✅ Aucune maison à traiter.');

            return self::SUCCESS;
        }

        $this->info("🎨 Génération des images pour {$houses->count()} maison(s)...\n");

        $progressBar = $this->output->createProgressBar($houses->count() * 4); // 4 images par maison en moyenne

        foreach ($houses as $house) {
            $this->newLine(2);
            $this->info("📍 {$house->title}");

            // Si la maison a un attribut image_prompts (depuis le seeder)
            if (property_exists($house, 'image_prompts') && is_array($house->image_prompts)) {
                $prompts = $house->image_prompts;
            } else {
                // Prompts par défaut si non définis
                $prompts = [
                    "Professional real estate photography of a {$house->houseType->name}, exterior view, {$house->address}, Belgium, bright daylight, high quality",
                    "Interior living room of a {$house->houseType->name}, modern design, bright and spacious, Belgian architecture",
                    "Kitchen interior of a {$house->houseType->name}, modern appliances, clean design, Belgian home",
                    "Bedroom interior of a {$house->houseType->name}, comfortable and cozy, natural light, Belgian interior design",
                ];
            }

            foreach ($prompts as $index => $prompt) {
                $this->info('  🖼️  Image '.($index + 1).'...');

                try {
                    $imageData = $this->generateImage($prompt, $apiKey);

                    if ($imageData) {
                        // Décoder le base64 et sauvegarder
                        $this->saveImage($house, $imageData, $index + 1);
                        $this->line('     ✅ Générée!');
                    } else {
                        $this->warn('     ⚠️  Échec de la génération');
                    }
                } catch (\Exception $e) {
                    $this->error('     ❌ Erreur: '.$e->getMessage());
                }

                $progressBar->advance();

                // Pause pour éviter le rate limiting (1 seconde entre chaque image)
                sleep(1);
            }
        }

        $progressBar->finish();
        $this->newLine(2);
        $this->info('🎉 Génération terminée!');

        return self::SUCCESS;
    }

    /**
     * Génère une image via OpenRouter API.
     */
    private function generateImage(string $prompt, string $apiKey): ?string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout(60) // 60 secondes timeout
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'openai/gpt-5-image-mini',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'modalities' => ['image', 'text'],
            ])
        ;

        if (!$response->successful()) {
            throw new \Exception('API Error: '.$response->body());
        }

        $data = $response->json();

        // Extraire l'image de la réponse
        if (isset($data['choices'][0]['message']['images'][0]['image_url']['url'])) {
            $imageUrl = $data['choices'][0]['message']['images'][0]['image_url']['url'];

            // L'URL est au format: data:image/png;base64,iVBORw0KG...
            if (preg_match('/^data:image\/(\w+);base64,(.+)$/', $imageUrl, $matches)) {
                return $matches[2]; // Retourner seulement le base64
            }
        }

        return null;
    }

    /**
     * Sauvegarde l'image et l'associe à la maison.
     */
    private function saveImage(House $house, string $base64Data, int $index): void
    {
        // Décoder le base64
        $imageData = base64_decode($base64Data);

        // Générer un nom de fichier unique
        $filename = 'houses/'.$house->id.'_'.$index.'_'.time().'.png';

        // Sauvegarder dans storage/app/public
        Storage::disk('public')->put($filename, $imageData);

        // Créer l'enregistrement dans la DB
        $house->images()->create([
            'path' => $filename,
        ]);
    }
}
