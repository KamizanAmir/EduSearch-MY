<?php

namespace Database\Factories;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Institution>
 */
class InstitutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' University',
            'state' => fake()->randomElement(['Kuala Lumpur', 'Selangor', 'Penang', 'Johor', 'Perak', 'Sarawak', 'Sabah']),
            'type' => fake()->randomElement(['Public', 'Private', 'GLC']),
            'description' => fake()->paragraph(),
        ];
    }
}
