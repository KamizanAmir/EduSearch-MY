<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $levels = ['Foundation', 'Diploma', 'Bachelor Degree', 'Master Degree', 'PhD'];

        foreach ($levels as $level) {
            \App\Models\StudyLevel::create(['name' => $level]);
        }

        $institutions = \App\Models\Institution::factory(20)->create();
        $studyLevels = \App\Models\StudyLevel::all();

        foreach ($institutions as $institution) {
            foreach (range(1, 10) as $index) {
                \App\Models\Course::factory()->create([
                    'institution_id' => $institution->id,
                    'study_level_id' => $studyLevels->random()->id,
                    'name' => 'Program in ' . fake()->jobTitle(),
                ]);
            }
        }
    }
}
