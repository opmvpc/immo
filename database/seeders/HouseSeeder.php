<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\HouseType;
use App\Models\User;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer l'utilisateur de test
        $user = User::where('email', 'test@example.com')->firstOrFail();

        // Récupérer les types de maisons
        $appartement = HouseType::where('slug', 'appartement')->first();
        $maison = HouseType::where('slug', 'maison')->first();
        $villa = HouseType::where('slug', 'villa')->first();
        $studio = HouseType::where('slug', 'studio')->first();
        $loft = HouseType::where('slug', 'loft')->first();

        // Données en dur avec prompts détaillés pour l'IA
        $houses = [
            // Appartement moderne à Bruxelles
            [
                'house_type_id' => $appartement->id,
                'title' => 'Appartement moderne avec vue sur le Parc Royal',
                'price' => 395000,
                'address' => fake('be_FR')->streetAddress().', 1000 Bruxelles',
                'bedrooms' => 2,
                'size' => 85.5,
                'description' => "Magnifique appartement de 85m² situé au 5ème étage d'un immeuble Art Déco rénové. Le séjour lumineux de 35m² s'ouvre sur un balcon avec vue panoramique sur le Parc Royal. La cuisine moderne entièrement équipée (électroménagers Siemens) dispose d'un îlot central en quartz. Deux chambres spacieuses avec parquet en chêne massif, une salle de bains avec douche italienne et baignoire. Cave privative et parking sécurisé inclus.",
                'image_prompts' => [
                    'Modern Belgian apartment living room with Art Deco touches, floor-to-ceiling windows overlooking Brussels Royal Park, contemporary grey sofa, oak parquet flooring, natural daylight, minimal Scandinavian design, plants, architectural photography, high-end interior',
                    'Luxury apartment kitchen with white quartz island, Siemens appliances, handleless cabinets, pendant lights, modern European design, clean lines, Brussels city view through window',
                    'Elegant apartment bedroom with oak hardwood floors, large windows, soft grey walls, minimalist furniture, cozy textiles, Brussels architecture visible outside',
                    'Modern bathroom with Italian shower, freestanding bathtub, marble tiles, chrome fixtures, large mirror, warm lighting, spa-like atmosphere',
                ],
            ],

            // Maison de maître à Ixelles
            [
                'house_type_id' => $maison->id,
                'title' => 'Maison de maître rénovée - Quartier des étangs',
                'price' => 875000,
                'address' => fake('be_FR')->streetAddress().', 1050 Ixelles',
                'bedrooms' => 4,
                'size' => 220,
                'description' => "Superbe maison de maître de 1920 entièrement rénovée avec goût. Sur 3 niveaux, elle offre 220m² habitables. Au rez: hall d'entrée avec carrelage d'origine, salon-salle à manger de 50m² avec cheminée en marbre, cuisine équipée ouverte sur un jardin arboré de 150m². 1er étage: 3 chambres, bureau, salle de bains. 2ème étage: suite parentale avec dressing et salle de bains privative. Sous-sol aménagé avec buanderie et cave à vin. Proche des étangs d'Ixelles.",
                'image_prompts' => [
                    'Elegant 1920s Belgian townhouse exterior, red brick facade with white window frames, Art Nouveau details, small front garden with iron gate, tree-lined street, Brussels Ixelles neighborhood, autumn afternoon light',
                    'Grand living room in renovated Belgian townhouse, white marble fireplace, herringbone parquet floors, high ceilings with moldings, large bay windows, classic meets contemporary interior, natural light',
                    'Spacious modern kitchen opening to garden, white cabinets, marble countertops, island with bar stools, large windows overlooking green yard with mature trees, Belgian home interior',
                    'Luxurious master suite with walk-in closet, wooden floors, soft neutral tones, velvet armchair, large windows, elegant Belgian interior design',
                ],
            ],

            // Studio étudiant à Louvain-la-Neuve
            [
                'house_type_id' => $studio->id,
                'title' => 'Studio cosy proche UCLouvain',
                'price' => 145000,
                'address' => fake('be_FR')->streetAddress().', 1348 Louvain-la-Neuve',
                'bedrooms' => 1,
                'size' => 32,
                'description' => "Studio parfait pour étudiant ou premier achat. 32m² optimisés avec coin nuit séparé par une verrière, kitchenette équipée (frigo, plaques, micro-ondes), salle de douche avec WC. Nombreux rangements intégrés. Situé à 5 minutes à pied de l'UCLouvain et du centre commercial. Charges réduites (50€/mois incluant chauffage et eau). Cave et local vélos communs. Immeuble récent (2018) avec ascenseur.",
                'image_prompts' => [
                    'Compact modern studio apartment, open plan layout with glass partition separating sleeping area, light wood floors, white walls, built-in storage, small kitchenette, bright and airy, student-friendly Belgian interior',
                    'Cozy studio sleeping nook with glass divider, single bed with storage underneath, floating shelves, warm lighting, minimalist Scandinavian style, small but functional',
                    'Modern studio kitchenette with white cabinets, compact appliances, small breakfast bar, good use of space, bright window, student apartment Belgium',
                    'Small modern bathroom with walk-in shower, white tiles, chrome fixtures, mirror cabinet, efficient use of space, clean design',
                ],
            ],

            // Villa contemporaine à Waterloo
            [
                'house_type_id' => $villa->id,
                'title' => 'Villa d\'architecte avec piscine chauffée',
                'price' => 1250000,
                'address' => fake('be_FR')->streetAddress().', 1410 Waterloo',
                'bedrooms' => 5,
                'size' => 350,
                'description' => "Villa d'exception construite en 2020 par l'architecte Marc Corbiau. 350m² sur un terrain de 1200m² paysagé. Architecture contemporaine avec grandes baies vitrées et matériaux nobles (béton ciré, bois, pierre). Rez: immense living de 80m² ouvert sur terrasse et piscine chauffée 12x5m, cuisine Bulthaup, bureau, WC invités. Étage: 4 chambres dont suite parentale 40m² avec dressing et salle de bains, 2 salles de bains supplémentaires. Sous-sol: home cinéma, salle de sport, cave à vin, double garage. Domotique complète, panneaux solaires, pompe à chaleur.",
                'image_prompts' => [
                    'Ultra-modern architectural villa exterior, concrete and wood facade, floor-to-ceiling glass walls, flat roof, minimalist design, manicured lawn, outdoor heated pool, Belgian contemporary architecture, sunset lighting',
                    'Spectacular open-plan living space, 80 square meters, double-height ceiling, concrete flooring, Bulthaup kitchen visible, massive sliding glass doors opening to pool terrace, designer furniture, luxury Belgian villa interior',
                    'Heated outdoor swimming pool 12x5 meters, modern villa backdrop, wooden deck, lounge chairs, landscaped garden, contemporary Belgian architecture, summer evening',
                    'Luxurious master bedroom suite, 40 square meters, floor-to-ceiling windows, walk-in closet visible, minimal furniture, neutral tones, high-end Belgian interior design, natural light',
                ],
            ],

            // Loft industriel à Gand
            [
                'house_type_id' => $loft->id,
                'title' => 'Loft industriel dans ancienne filature',
                'price' => 425000,
                'address' => fake('be_FR')->streetAddress().', 9000 Gand',
                'bedrooms' => 2,
                'size' => 140,
                'description' => "Exceptionnel loft de 140m² aménagé dans une ancienne filature textile de 1890. Volumes impressionnants avec hauteur sous plafond de 4,5m, poutres métalliques apparentes, briques d'époque. Espace de vie ouvert avec cuisine US sur mesure en acier et bois, coin repas, salon avec cheminée suspendue design. Mezzanine en métal avec 2 chambres. Salle de bains style industriel avec douche walk-in et mobilier béton ciré. Quartier branché des Docks, proche du SMAK et des quais de la Lys.",
                'image_prompts' => [
                    'Industrial loft interior in converted 1890s textile mill, exposed brick walls, metal beams, 4.5m high ceilings, large factory windows, open floor plan, custom steel and wood kitchen, suspended designer fireplace, vintage industrial style, Ghent Belgium',
                    'Industrial loft kitchen, custom-made steel and wood units, concrete countertops, exposed brick, metal shelving, vintage pendant lights, urban industrial design, former factory space',
                    'Metal mezzanine bedroom in industrial loft, exposed beams and ductwork, brick walls, large windows, minimalist bed, industrial style furniture, raw materials, Ghent Belgium',
                    'Industrial bathroom with concrete vanity, walk-in shower, exposed pipes as design feature, brick walls, large mirror, Edison bulb lights, urban loft style',
                ],
            ],

            // Appartement familial à Liège
            [
                'house_type_id' => $appartement->id,
                'title' => 'Grand appartement familial - Quartier Outremeuse',
                'price' => 285000,
                'address' => fake('be_FR')->streetAddress().', 4000 Liège',
                'bedrooms' => 3,
                'size' => 125,
                'description' => "Spacieux appartement traversant de 125m² au 2ème étage sans ascenseur. Hall d'entrée, vaste séjour de 40m² très lumineux avec balcon exposé sud, salle à manger séparée, cuisine équipée semi-ouverte. Côté nuit: 3 grandes chambres (15, 12 et 10m²), salle de bains avec baignoire, salle de douche séparée, WC indépendant. Chauffage au gaz, double vitrage PVC. Cave et grenier. Quartier dynamique d'Outremeuse, proche écoles, commerces et transports.",
                'image_prompts' => [
                    'Bright family apartment living room, 40 square meters, south-facing balcony, comfortable sofa, dining area visible, parquet floors, Belgian family home interior, natural daylight, warm atmosphere',
                    'Belgian apartment kitchen and dining area, semi-open layout, white cabinets, wooden table with chairs, family-friendly space, practical design, good natural light',
                    "Spacious children's bedroom in Belgian apartment, 15 square meters, single bed, desk for homework, built-in wardrobe, colorful accents, bright and cheerful",
                    'Family bathroom with bathtub, white tiles, window for natural ventilation, practical storage, shower curtain, Belgian apartment interior',
                ],
            ],

            // Maison unifamiliale à Namur
            [
                'house_type_id' => $maison->id,
                'title' => 'Maison 4 façades avec grand jardin',
                'price' => 475000,
                'address' => fake('be_FR')->streetAddress().', 5000 Namur',
                'bedrooms' => 4,
                'size' => 180,
                'description' => 'Belle maison 4 façades sur 8 ares. Rez: hall, WC, bureau, séjour 35m² avec poêle à pellets, véranda 20m² donnant sur terrasse et jardin sud-ouest, cuisine équipée ouverte, arrière-cuisine. Étage: hall de nuit, 4 chambres (dont une avec balcon), salle de bains, WC séparé. Grenier aménageable de 60m². Sous-sol: garage 2 voitures, buanderie, cave, chaufferie (chaudière gaz condensation 2019). Jardin entièrement clôturé avec abri de jardin et potager. Proche de toutes commodités.',
                'image_prompts' => [
                    'Detached Belgian family house exterior, four facades, red brick, white window shutters, pitched tile roof, well-maintained front lawn, driveway, suburban Namur neighborhood, sunny day',
                    'Cozy family living room with pellet stove, comfortable sectional sofa, TV unit, connected to conservatory with garden view, warm Belgian home interior, family-friendly',
                    'Bright conservatory extension with garden views, tiled floor, plants, comfortable seating, large windows, connection between indoor and outdoor living, Belgian home',
                    'Established southwest-facing garden, lawn area, vegetable patch, garden shed, mature trees, privacy fence, patio with outdoor furniture, family garden Belgium',
                ],
            ],

            // Appartement terrasse à Anvers
            [
                'house_type_id' => $appartement->id,
                'title' => 'Penthouse avec terrasse panoramique - Zuid',
                'price' => 695000,
                'address' => fake('be_FR')->streetAddress().', 2000 Anvers',
                'bedrooms' => 3,
                'size' => 165,
                'description' => "Sublime penthouse de 165m² + 80m² de terrasses au 8ème et dernier étage. Living cathedral de 60m² avec cuisine ouverte haut de gamme (Gaggenau), accès terrasse sud avec vue imprenable sur l'Escaut et la vieille ville. 3 chambres dont suite parentale avec salle de bains en-suite et accès terrasse privée. 2ème salle de bains, WC séparé, buanderie. Finitions luxueuses: parquet Bauwerk, domotique KNX, climatisation réversible. Double parking et cave. Dans le quartier branché du Zuid, proche KMSKA et Marnixplaats.",
                'image_prompts' => [
                    'Luxury penthouse living room with cathedral ceiling, 60 square meters, high-end open Gaggenau kitchen, floor-to-ceiling windows, access to south terrace, panoramic Antwerp city view including Scheldt river, contemporary design, Belgian luxury interior',
                    'Spectacular penthouse terrace, 80 square meters, outdoor lounge furniture, planters with greenery, glass balustrade, panoramic view over Antwerp cityscape and Scheldt river, sunset lighting, luxury outdoor living',
                    'Designer penthouse kitchen, Gaggenau appliances, handle-less white cabinets, large island with bar stools, integrated lighting, minimalist luxury, view to living area and terrace beyond',
                    'Elegant penthouse master bedroom with ensuite bathroom visible through glass partition, king bed, built-in wardrobes, access to private terrace, soft neutral palette, luxury Belgian interior',
                ],
            ],
        ];

        // Créer les maisons
        foreach ($houses as $houseData) {
            // Extraire les prompts d'images avant de créer la maison
            $imagePrompts = $houseData['image_prompts'];
            unset($houseData['image_prompts']);

            // Créer la maison
            $house = $user->houses()->create($houseData);

            // Stocker les prompts dans un attribut temporaire pour la commande de génération
            // Les images seront générées via: php artisan houses:generate-images
            $house->image_prompts = $imagePrompts;
        }

        $this->command->info('✅ '.count($houses).' maisons créées avec succès!');
        $this->command->info('💡 Utilisez "php artisan houses:generate-images" pour générer les images via IA.');
    }
}
