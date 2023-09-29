<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{

    public function configure(): static
    {
        return $this->afterMaking(function (Test $test) {
            if (!isset($test->user_id)) {
                $test->user_id = $test->course->user_id;
            }
        })->afterCreating(function (Test $test) {
            // ...
        });
    }
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->text(),
            'subject_id' => fake()->numberBetween(1, 4),
            'grade_id' => fake()->numberBetween(1, 17),
        ];
    }
}
