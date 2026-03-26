<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'institution_id' => \App\Models\Institution::factory(),
            'study_level_id' => \App\Models\StudyLevel::factory(),
            'name' => fake()->jobTitle(),
            'duration_months' => fake()->randomElement([12, 24, 36, 48]),
            'estimated_fee' => fake()->randomFloat(2, 5000, 100000),
        ];
    }
}
