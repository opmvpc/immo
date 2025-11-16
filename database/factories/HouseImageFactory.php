<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\House;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HouseImage>
 */
class HouseImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'house_id' => House::factory(),
            'path' => 'houses/placeholder-' . fake()->numberBetween(1, 5) . '.jpg',
        ];
    }
}
