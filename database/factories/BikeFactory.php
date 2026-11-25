<?php

namespace Database\Factories;

use App\Models\Bike;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bike>
 */
class BikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modelsByBrand = [
            'Orbea' => ['Oiz H30', 'Alma H30', 'Occam H30'],
            'Trek' => ['Marlin 7', 'Fuel EX 5', 'Domane AL 2'],
            'Specialized' => ['Rockhopper Comp 29', 'Chisel Comp'],
            'Giant' => ['Talon 1'],
            'Canyon' => ['Grand Canyon 7'],
        ];
        $brand = fake()->randomElement(array_keys($modelsByBrand));

        return [
            'serial_number' => fake()->unique()->regexify('[A-Z0-9]{10}'),
            'brand' => $brand,
            'model' => $brand . ' ' . fake()->randomElement($modelsByBrand[$brand]),
            'price_per_hour' => fake()->randomFloat(2, 5, 50),
            'stock' => fake()->numberBetween(0, 20),
            'colour' => fake()->safeColorName(),
            'img_route' => null,
            'size' => fake()->numberBetween(47, 53),
            'status' => fake()->randomElement(['available', 'maintenance', 'retired']),
        ];
    }
}
