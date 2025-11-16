<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\HouseType;
use Illuminate\Database\Seeder;

class HouseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Appartement',
                'slug' => 'appartement',
                'description' => 'Logement dans un immeuble, généralement sur un seul niveau.',
            ],
            [
                'name' => 'Maison',
                'slug' => 'maison',
                'description' => 'Habitation individuelle ou mitoyenne, souvent sur plusieurs niveaux.',
            ],
            [
                'name' => 'Villa',
                'slug' => 'villa',
                'description' => 'Maison individuelle de standing avec terrain et équipements haut de gamme.',
            ],
            [
                'name' => 'Studio',
                'slug' => 'studio',
                'description' => 'Petit logement composé d\'une seule pièce principale.',
            ],
            [
                'name' => 'Loft',
                'slug' => 'loft',
                'description' => 'Grand espace ouvert, souvent aménagé dans un ancien bâtiment industriel.',
            ],
            [
                'name' => 'Duplex',
                'slug' => 'duplex',
                'description' => 'Logement sur deux niveaux reliés par un escalier intérieur.',
            ],
        ];

        foreach ($types as $type) {
            HouseType::create($type);
        }

        $this->command->info('✅ ' . count($types) . ' types de maisons créés!');
    }
}
