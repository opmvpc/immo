<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $houseTypes = [
            'Maison',
            'Appartement',
            'Villa',
            'Studio',
            'Loft',
            'Duplex',
        ];

        $cities = [
            'Paris',
            'Lyon',
            'Marseille',
            'Bordeaux',
            'Toulouse',
            'Nice',
            'Nantes',
            'Strasbourg',
            'Montpellier',
            'Lille',
        ];

        $type = fake()->randomElement($houseTypes);
        $city = fake()->randomElement($cities);

        return [
            'user_id' => User::factory(),
            'title' => "{$type} à {$city}",
            'price' => fake()->randomFloat(2, 50000, 1000000),
            'address' => fake()->streetAddress() . ', ' . fake()->postcode() . ' ' . $city,
            'bedrooms' => fake()->numberBetween(1, 6),
            'size' => fake()->randomFloat(2, 20, 300),
            'description' => fake()->paragraphs(3, true),
        ];
    }
}
