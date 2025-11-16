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
        $duplex = HouseType::where('slug', 'duplex')->first();

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
                    'Modern Belgian apartment living room, sage green accent wall, beige linen sofa, oak parquet, fiddle leaf fig plant in corner, coffee table with magazines, Brussels Royal Park view through large windows, warm afternoon light, lived-in but tidy, contemporary European interior',
                    'Apartment kitchen with white quartz island, two bar stools with navy velvet cushions, copper pendant lights, fresh herbs on windowsill, coffee mug on counter, Siemens appliances, warm wood cabinets, slightly lived-in feel',
                    'Cozy bedroom with terracotta bedding, oak floors, reading lamp on nightstand, book left open on bed, small monstera plant, warm beige walls, Brussels rooftops visible through window, morning light',
                    'Modern bathroom with Italian shower, subway white tiles, eucalyptus hanging in shower, towels on heated rack, small succulents on shelf, natural light from window, clean but lived-in',
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
                    'Elegant 1920s Belgian red brick townhouse exterior, white Art Nouveau window frames, ornate ironwork, small front garden with lavender and rose bushes, wrought iron gate, tree-lined cobblestone street, Ixelles Brussels, golden autumn afternoon light',
                    'Sophisticated living room in renovated 1920s townhouse, active fireplace with white marble mantle, herringbone oak parquet, plush navy velvet sofa, vintage Turkish rug, tall fiddle leaf fig, high molded ceilings, large bay windows, warm evening ambiance, luxury Belgian interior',
                    'High-end kitchen opening to garden, cream Shaker cabinets, black marble countertops, brass hardware, fresh flowers on island, wine glasses and fruit bowl, large French windows overlooking mature garden with old oak trees, warm afternoon light, elegant but lived-in',
                    'Master bedroom suite with walk-in closet visible through open door, wooden herringbone floors, warm grey walls, king bed with linen duvet, vintage leather armchair, stack of books on nightstand, large windows with sheer curtains, potted snake plant, refined luxury',
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
                    'Student studio apartment, lived-in look, laptop open on desk with textbooks scattered around, unmade single bed with colorful throw blanket, IKEA posters on wall, empty coffee mugs, charging phone, small pothos plant, clothes draped on chair, compact but cozy, afternoon light through window, realistic student life Belgium',
                    'Tiny student kitchenette, white cabinets with some doors left open, instant noodles and cereal boxes visible, dirty dishes in sink, coffee maker, small fridge covered in magnets and photos, breakfast bar with backpack hanging on stool, functional but messy student space',
                    'Small sleeping area behind glass partition, unmade bed with rumpled sheets, pile of laundry on floor, string lights hung above bed, band posters, floating shelf with books stacked horizontally and vertically, phone charger, water bottle, student bedroom chaos',
                    'Compact student bathroom, walk-in shower with shampoo bottles on floor, towel hanging on door, mirror with toothbrush and products scattered on small shelf, some clothes hanging to dry, practical basic tiles, lived-in student space',
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
                    'Ultra-luxury modern architectural villa exterior, black concrete and warm wood cladding facade, floor-to-ceiling glass walls reflecting sky, cantilevered flat roof, perfectly manicured Japanese-inspired garden, heated infinity pool, sculptural olive trees, Belgian contemporary architecture, golden hour sunset',
                    'Breathtaking 80 sqm open living space, triple-height ceiling, polished concrete floors, floating staircase, premium Bulthaup kitchen island, Italian designer furniture, large contemporary art pieces, massive motorized glass doors fully open to pool terrace with outdoor lounge, warm evening lighting, ultra-luxury Belgian villa',
                    'Stunning heated infinity pool 12x5m, seamless edge, dark grey tiles, teak deck with luxury sunbeds, large modern villa with illuminated interiors visible, mature palm trees, landscape lighting, summer twilight, architectural photography',
                    'Expansive 40 sqm master suite, floor-to-ceiling windows overlooking private garden, platform king bed, walk-in dressing room with backlit wardrobes visible through glass, floating nightstands, statement pendant lights, neutral palette with warm wood accents, ultra-high-end Belgian interior',
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
                    'Dramatic industrial loft in 1890s textile mill conversion, exposed red brick walls with original patina, massive black metal beams and columns, 4.5m high ceilings, huge arched factory windows with black frames, custom steel and reclaimed wood kitchen, suspended black fireplace, worn leather sofa, vintage factory cart as coffee table, rubber plant in corner, moody natural light, authentic industrial character Ghent Belgium',
                    'Industrial loft kitchen, black steel cabinets with brass hardware, thick reclaimed wood shelves, concrete countertops, exposed brick backsplash, vintage factory pendant lights with Edison bulbs, stainless steel appliances, cast iron pots hanging, espresso machine, urban loft living Ghent',
                    'Industrial mezzanine bedroom, black metal structure and railing, original exposed ductwork and pipes, weathered brick walls, large factory window, low platform bed with grey linen, vintage metal locker as wardrobe, concrete floor, hanging bare bulb, raw authentic materials',
                    'Industrial bathroom, polished concrete floating vanity, black steel frame mirror, walk-in shower with exposed copper pipes as design feature, subway tiles, Edison bulb lights, vintage hooks, rolled towels, weathered brick wall, urban loft style',
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
                    'Lived-in family living room, comfortable grey sectional sofa with throw pillows, kids toys scattered on floor, coloring books on coffee table, south-facing balcony with potted geraniums, dining table visible with homework and papers, family photos on walls, spider plant hanging in corner, warm natural light, realistic family home Belgium',
                    'Family kitchen and dining area, cream cabinets, wooden table with mismatched chairs, fruit bowl and kids drawings held by magnets on fridge, breakfast dishes in sink, tea towels hanging, small herb pots on windowsill, semi-open to living room, lived-in but clean, Belgian family apartment',
                    "Realistic children's bedroom, single bed with superhero duvet, school bag hanging on door, toys and books scattered around, small desk with lamp and colored pencils, drawings taped on walls, LEGO on floor, small cactus on windowsill, afternoon light, typical kid's room Belgium",
                    'Family bathroom with bathtub, blue and white tiles, shower curtain, bath toys on tub edge, towels on rack, kids toothbrushes in cup, window with small spider plant, practical storage with products visible, lived-in family bathroom',
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
                    'Traditional Belgian detached house, four facades, warm red brick with white painted window shutters, grey pitched tile roof, well-maintained front garden with lavender bushes and small palm tree, concrete driveway with two cars, suburban Namur neighborhood, sunny spring day',
                    'Welcoming family living room, active black pellet stove, warm atmosphere, comfortable taupe sectional sofa with colorful cushions, flat screen TV, wooden coffee table with magazines and remote controls, opening to bright conservatory with garden view, family photos on mantle, spider plant, lived-in Belgian home',
                    'Bright conservatory extension, terracotta tiled floor, wicker furniture with floral cushions, various potted plants including large bird of paradise, floor-to-ceiling windows overlooking green garden, garden door open, sunlight streaming in, transitional space between inside and outside, Belgian family home',
                    'Established southwest garden, green lawn with childrens trampoline, raised bed vegetable patch with tomatoes and herbs, wooden garden shed, mature apple tree, wooden fence for privacy, stone patio with garden furniture and BBQ, family garden Belgium in summer',
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
                    'Stunning luxury penthouse living room, soaring cathedral ceiling with exposed beams, 60 sqm open space, premium Gaggenau kitchen with black marble island, full-height sliding glass doors wide open to south terrace, breathtaking panoramic view of Antwerp skyline and Scheldt river, golden hour light, modern charcoal grey sofa, designer coffee table, large contemporary art piece, luxury Belgian penthouse',
                    'Spectacular 80 sqm penthouse terrace, weathered teak decking, modern outdoor sectional with beige cushions, built-in planters with olive trees and lavender, frameless glass balustrade, sweeping panoramic cityscape view including Scheldt river and cathedral, string lights overhead, sunset golden hour, ultimate luxury outdoor living Antwerp',
                    'High-end penthouse kitchen, matte black Gaggenau appliances, handle-less cream cabinets, dramatic black marble waterfall island, three pendant lights, integrated wine fridge, bar stools with cognac leather, herringbone parquet, view through to living area and terrace with city skyline, sophisticated luxury',
                    'Elegant penthouse master bedroom, floor-to-ceiling windows with panoramic city view, platform king bed with premium grey linen, frosted glass ensuite bathroom visible, built-in walnut wardrobes, access to private terrace, abstract art above bed, reading sconces, refined luxury Belgian interior',
                ],
            ],

            // Kot étudiant ultra budget à Louvain-la-Neuve
            [
                'house_type_id' => $studio->id,
                'title' => 'Kot étudiant économique - Campus UCLouvain',
                'price' => 115000,
                'address' => fake('be_FR')->streetAddress().', 1348 Louvain-la-Neuve',
                'bedrooms' => 1,
                'size' => 18,
                'description' => "Petit kot de 18m² idéal pour étudiant avec budget serré. Espace de vie compact avec coin nuit, mini-kitchenette (frigo bar, 2 plaques), salle d'eau avec douche. Meublé basique inclus: lit, bureau, armoire. Situé en plein campus UCLouvain, à 2 minutes à pied des auditoires. Charges basses (40€/mois). Buanderie commune au rez. Immeuble années 80, bien entretenu.",
                'image_prompts' => [
                    'Tiny student room 18 sqm, very messy and lived-in, single bed unmade with gaming laptop on it, instant ramen cups stacked on desk, energy drink cans, posters covering walls including music bands and games, clothes pile on floor, backpack open with books spilling out, fairy lights, very small space, afternoon light, authentic student chaos Belgium',
                    'Cramped student mini kitchen corner, white laminate cabinet with chipped door, hot plate with pasta pot left out, mini fridge covered in beer brand stickers and takeaway menus, sink with unwashed dishes, instant coffee jar, cereal box open, very basic and messy student space',
                    'Small student bed area, crumpled duvet, pillow without case, clothes draped over chair, skateboard leaning on wall, guitar in corner, charging cables everywhere, sneakers under bed, movie posters, string lights, typical messy student bedroom Belgium',
                    'Basic student bathroom, small shower stall, plain white tiles, shampoo bottles on floor, towel on hook, mirror with toothpaste spots, toilet paper on sink, very basic functional space, budget student accommodation',
                ],
            ],

            // Duplex moderne style scandinave hygge à Bruxelles
            [
                'house_type_id' => $duplex->id,
                'title' => 'Duplex cosy style scandinave - Quartier Dansaert',
                'price' => 385000,
                'address' => fake('be_FR')->streetAddress().', 1000 Bruxelles',
                'bedrooms' => 2,
                'size' => 95,
                'description' => 'Charmant duplex de 95m² entièrement rénové dans un esprit scandinave chaleureux. Niveau inférieur: entrée, salon-salle à manger lumineux avec poêle à bois design, cuisine ouverte en bois clair, WC. Niveau supérieur: 2 chambres mansardées avec poutres apparentes, salle de bains avec baignoire. Parquet chêne clair partout, grandes fenêtres, décoration hygge. Cave. Quartier Dansaert branché, proche commerces et restaurants.',
                'image_prompts' => [
                    'Cozy Scandinavian hygge duplex living room, light oak floors, white walls, cream boucle sofa with chunky knit throws and wool cushions, modern black wood stove, floating shelves with books and ceramics, woven pendant light, large window with sheer linen curtains, potted yucca plant, warm candles, soft afternoon light, Danish-inspired Belgian home',
                    'Bright Scandinavian kitchen, light birch wood cabinets, white subway tiles, brass hardware, open shelving with white dishes and coffee cups, small dining table with mismatched wooden chairs, pendant lights, green herbs in pots, clean minimalist hygge style, natural light, cozy Belgian duplex',
                    'Attic bedroom with exposed white-painted beams, sloped ceiling, light oak floors, white linen bedding, chunky knit blanket in mustard yellow, floating nightstand with candles and book, woven basket for storage, dried pampas grass in vase, cozy Scandinavian bedroom Belgium',
                    'Simple Scandinavian bathroom, white walls and tiles, light wood vanity, round mirror, small bathtub, green plants, rolled white towels, minimalist fixtures, natural light from skylight, clean hygge aesthetic',
                ],
            ],

            // Cottage de campagne rustique en Ardennes
            [
                'house_type_id' => $maison->id,
                'title' => 'Cottage rustique en pierre - Durbuy',
                'price' => 295000,
                'address' => fake('be_FR')->streetAddress().', 6940 Durbuy',
                'bedrooms' => 3,
                'size' => 110,
                'description' => "Authentique cottage en pierre de 1880 dans un cadre champêtre. 110m² pleins de cachet avec murs en pierre apparente, poutres en chêne, cheminée d'époque. RDC: salon avec feu ouvert, cuisine rustique semi-ouverte, salle d'eau. Étage: 3 chambres sous toiture, salle de bains. Chauffage poêle à bois + électrique. Jardin arboré 500m² avec potager et poulailler. Vue dégagée sur campagne ardennaise. Calme absolu, idéal résidence secondaire ou télétravail.",
                'image_prompts' => [
                    'Rustic Belgian cottage living room, exposed stone walls with original mortar, thick oak ceiling beams, large working stone fireplace with fire burning, vintage burgundy velvet sofa, antique wooden coffee table, Persian rug on terracotta tiles, brass candlesticks, dried flowers in copper vase, warm cozy atmosphere, countryside Belgium Ardennes',
                    'Charming rustic country kitchen, exposed stone wall, wooden open shelves with vintage dishes, farmhouse sink, butcher block counters, copper pots hanging, fresh vegetables on table, dried herbs bunches, traditional Belgian cottage interior, natural window light',
                    'Cozy attic bedroom under wooden beams, wrought iron bed frame with patchwork quilt, stone wall visible, vintage wardrobe, bedside table with oil lamp, small window with lace curtain, rural Belgian cottage character, afternoon light',
                    'Country cottage garden, vegetable patch with tomatoes and pumpkins, small chicken coop with hens, apple tree, wildflower meadow beyond, rolling Ardennes hills in background, rustic wooden fence, authentic Belgian countryside',
                ],
            ],

            // Appartement Art Déco vintage à Bruxelles
            [
                'house_type_id' => $appartement->id,
                'title' => 'Appartement Art Déco avec cachet - Ixelles',
                'price' => 425000,
                'address' => fake('be_FR')->streetAddress().', 1050 Ixelles',
                'bedrooms' => 2,
                'size' => 105,
                'description' => "Superbe appartement Art Déco de 105m² dans immeuble de maître 1930, conservant ses éléments d'origine. Hall avec mosaïque géométrique, salon 35m² avec cheminée en marbre vert, bow-window, parquet à chevrons, moulures au plafond. Cuisine semi-ouverte rétro-moderne. 2 chambres, salle de bains avec baignoire sur pieds restaurée. Décoration vintage assumée, luminaires d'époque. Cave. Quartier calme d'Ixelles, proche Place Flagey.",
                'image_prompts' => [
                    'Elegant Art Deco apartment living room 1930s style, green marble fireplace mantle, geometric mosaic floor detail, herringbone parquet, bow window with original stained glass accents, vintage velvet emerald sofa, brass floor lamp, period chandelier, ornate ceiling moldings, antique mirror, potted palm, warm atmospheric lighting, authentic Brussels Art Deco interior',
                    'Vintage Art Deco kitchen with modern touches, mint green subway tiles, brass fixtures, open shelving with vintage glassware, restored 1930s inspired cabinets, geometric floor tiles, pendant light with brass shade, plants in ceramic pots, retro but functional Belgian apartment',
                    'Art Deco bedroom, herringbone oak floors, original moldings, vintage wooden wardrobe, brass bed frame with deep blue velvet headboard, geometric patterned rug, antique dressing table, period wall sconces, tall window with velvet drapes, sophisticated vintage Brussels style',
                    'Restored Art Deco bathroom, black and white geometric floor tiles, clawfoot bathtub, pedestal sink, octagonal mirror with brass frame, vintage light fixtures, houseplant in corner, original details preserved, elegant 1930s Belgian character',
                ],
            ],

            // Maison de ville étroite à rénover - Prix abordable
            [
                'house_type_id' => $maison->id,
                'title' => 'Maison de ville à rénover - Potentiel énorme',
                'price' => 235000,
                'address' => fake('be_FR')->streetAddress().', 4000 Liège',
                'bedrooms' => 3,
                'size' => 95,
                'description' => 'Maison de ville mitoyenne de 95m² offrant un beau potentiel après travaux de rénovation. RDC: entrée, salon, cuisine à refaire, accès petite cour. Étage 1: 2 chambres. Étage 2: grenier aménageable en chambre. Cave. Toiture refaite en 2020, électricité à revoir, chauffage gaz vétuste. Idéal premier achat ou investisseur. Quartier en plein développement de Liège, proche gare des Guillemins et centre-ville. Prix attractif pour projet de rénovation.',
                'image_prompts' => [
                    'Renovation project living room, dated 1980s decor, worn floral wallpaper peeling at corners, old brown tile floor, outdated radiator, plain walls needing paint, basic furniture, potential visible through large windows with good light, typical Belgian townhouse needing renovation',
                    'Kitchen requiring renovation, old laminate cabinets from 1990s, dated appliances, worn linoleum floor, plain walls, basic sink, window overlooking small courtyard, functional but outdated, fixer-upper potential Belgium',
                    'Basic bedroom needing updating, simple white walls with some scuffs, old carpet, plain window, radiator, empty room showing good proportions and natural light, renovation project with potential',
                    'Small neglected courtyard, concrete paving with weeds growing through cracks, old wooden fence needing repair, brick walls, potential for nice urban garden with work, Belgian townhouse exterior space',
                ],
            ],

            // Studio minimaliste japonais
            [
                'house_type_id' => $studio->id,
                'title' => 'Studio zen inspiration japonaise - Etterbeek',
                'price' => 165000,
                'address' => fake('be_FR')->streetAddress().', 1040 Etterbeek',
                'bedrooms' => 1,
                'size' => 38,
                'description' => "Studio de 38m² entièrement rénové dans un esprit minimaliste japonais apaisant. Espace ouvert avec tatami corner pour méditation, kitchenette intégrée en bois naturel et blanc mat, rangements invisibles, salle d'eau avec douche à l'italienne et carrelage effet pierre. Tons naturels: blanc, beige, bois clair. Placard japonais coulissant séparant le coin nuit. Très lumineux, calme, vue sur jardin intérieur zen. Proche UE et Montgomery. Charges 60€/mois.",
                'image_prompts' => [
                    'Zen minimalist Japanese-inspired studio, open space with light oak floors, white walls, low wooden platform bed with crisp white linen, shoji-style sliding door, corner with zafu meditation cushion on small tatami mat, single bonsai on floating shelf, paper lantern pendant light, large window with bamboo blind, extremely calm and minimal, Japanese aesthetic Belgium',
                    'Minimalist Japanese kitchen, light wood and white matte cabinets, handleless design, integrated appliances, single pendant light, stone countertop, wooden utensils in ceramic holder, green tea set, clean lines, zen simplicity, natural materials',
                    'Japanese-style sleeping corner, low wooden platform bed, white cotton duvet, single pillow, sliding shoji screen partially open, small succulent on windowsill, warm natural light, ultimate minimalism, peaceful Japanese-Belgian interior',
                    'Minimalist zen bathroom, walk-in shower with stone-effect tiles, wooden bath mat, wall-mounted white sink, round mirror, bamboo plant, white towels neatly rolled, very clean simple lines, Japanese spa aesthetic',
                ],
            ],

            // Maison avec jardin bohème
            [
                'house_type_id' => $maison->id,
                'title' => 'Maison bohème avec jardin enchanteur - Gand',
                'price' => 345000,
                'address' => fake('be_FR')->streetAddress().', 9000 Gand',
                'bedrooms' => 3,
                'size' => 115,
                'description' => 'Charmante maison de caractère 1920 au style bohème assumé. 115m² décorés avec personnalité: salon avec cheminée et papiers peints vintage, cuisine colorée semi-ouverte, véranda vitrée donnant sur jardin. Étage: 3 chambres aux ambiances différentes, salle de bains avec baignoire rétro. Jardin de 200m² aménagé en oasis bohème: plantes luxuriantes, hamac, coin feu, potager aromatique. Quartier artistique de Gand, proche Vooruit et Sint-Pietersnieuwstraat.',
                'image_prompts' => [
                    'Bohemian eclectic living room, vintage floral wallpaper in warm tones, mismatched colorful cushions on worn leather sofa, macrame wall hanging, gallery wall with vintage frames and botanical prints, old fireplace mantle with candles and crystals, Moroccan rug, hanging plants including trailing pothos, rattan chair, warm golden hour light, maximalist boho Belgian home',
                    'Colorful bohemian kitchen, open shelving with eclectic mix of colorful dishes, patterned tiles backsplash in blue and yellow, wooden counters, hanging plants, vintage jars with dried flowers, string lights, fruit bowl, herbs in mismatched pots, cheerful lived-in boho style Belgium',
                    'Boho bedroom, brass bed frame with colorful patterned bedding, layered textiles, macrame wall hanging above bed, plants on windowsill, vintage trunk as nightstand, string lights, dreamcatcher, warm wood floors with patterned rug, eclectic bohemian Belgian interior',
                    'Enchanting bohemian garden, wild lush planting with ferns and hostas, colorful hammock between trees, fairy lights strung overhead, outdoor cushions in bright colors, small firepit area, herb garden in vintage containers, overgrown romantic cottage garden style Belgium',
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
