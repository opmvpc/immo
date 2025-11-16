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

            // Générer toutes les images en parallèle pour cette maison
            $this->generateImagesInParallel($house, $prompts, $apiKey, $progressBar);
        }

        $progressBar->finish();
        $this->newLine();
        $this->newLine(2);
        $this->info('🎉 Génération terminée!');

        return self::SUCCESS;
    }

    /**
     * Génère plusieurs images en parallèle pour une maison.
     *
     * @param mixed $progressBar
     */
    private function generateImagesInParallel(House $house, array $prompts, string $apiKey, $progressBar): void
    {
        $count = count($prompts);
        $this->info("  🚀 Génération de {$count} images en parallèle...");

        $failedImages = [];

        // Préparer les requêtes en pool (parallèles)
        $responses = Http::pool(function ($pool) use ($prompts, $apiKey) {
            $requests = [];

            foreach ($prompts as $index => $prompt) {
                $requests[] = $pool->withHeaders([
                    'Authorization' => 'Bearer '.$apiKey,
                    'Content-Type' => 'application/json',
                ])
                    ->timeout(120) // 120 secondes timeout
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
            }

            return $requests;
        });

        // Traiter les réponses
        foreach ($responses as $index => $response) {
            $progressBar->advance();
            $imageNumber = $index + 1;

            try {
                if ($response->successful()) {
                    $imageData = $this->extractImageFromResponse($response->json());

                    if ($imageData) {
                        $this->saveImage($house, $imageData, $imageNumber);
                        $this->line("     ✅ Image {$imageNumber} générée!");
                    } else {
                        $this->warn("     ⚠️  Image {$imageNumber}: Pas de données d'image");
                        $failedImages[$imageNumber] = $prompts[$index];
                    }
                } else {
                    $this->error("     ❌ Image {$imageNumber}: {$response->status()}");
                    $failedImages[$imageNumber] = $prompts[$index];
                }
            } catch (\Exception $e) {
                $this->error("     ❌ Image {$imageNumber}: {$e->getMessage()}");
                $failedImages[$imageNumber] = $prompts[$index];
            }
        }

        // Retry les images qui ont échoué
        if (!empty($failedImages)) {
            $this->retryFailedImages($house, $failedImages, $apiKey, $progressBar);
        }
    }

    /**
     * Retry la génération des images qui ont échoué.
     *
     * @param mixed $progressBar
     */
    private function retryFailedImages(House $house, array $failedImages, string $apiKey, $progressBar, int $attempt = 1, int $maxAttempts = 3): void
    {
        if ($attempt > $maxAttempts) {
            $this->error("     💀 Abandon après {$maxAttempts} tentatives pour ".count($failedImages).' image(s)');

            return;
        }

        $this->newLine();
        $this->warn("  🔄 Retry tentative {$attempt}/{$maxAttempts} pour ".count($failedImages).' image(s)...');

        $stillFailing = [];

        foreach ($failedImages as $imageNumber => $prompt) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$apiKey,
                    'Content-Type' => 'application/json',
                ])
                    ->timeout(120)
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

                if ($response->successful()) {
                    $imageData = $this->extractImageFromResponse($response->json());

                    if ($imageData) {
                        $this->saveImage($house, $imageData, $imageNumber);
                        $this->line("     ✅ Image {$imageNumber} générée (retry)!");
                    } else {
                        $this->warn("     ⚠️  Image {$imageNumber}: Toujours pas de données");
                        $stillFailing[$imageNumber] = $prompt;
                    }
                } else {
                    $this->error("     ❌ Image {$imageNumber}: Échec retry");
                    $stillFailing[$imageNumber] = $prompt;
                }
            } catch (\Exception $e) {
                $this->error("     ❌ Image {$imageNumber}: {$e->getMessage()}");
                $stillFailing[$imageNumber] = $prompt;
            }

            // Pause courte entre chaque retry
            sleep(1);
        }

        // Si encore des échecs, retry récursif
        if (!empty($stillFailing)) {
            $this->retryFailedImages($house, $stillFailing, $apiKey, $progressBar, $attempt + 1, $maxAttempts);
        }
    }

    /**
     * Extrait l'image base64 de la réponse API.
     */
    private function extractImageFromResponse(array $data): ?string
    {
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
