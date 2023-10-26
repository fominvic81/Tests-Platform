<?php

namespace Database\Factories;

use App\Enums\Accessibility;
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
            'published' => fake()->boolean(90),
            'accessibility' => fake()->randomElement(Accessibility::cases()),
            'subject_id' => fake()->numberBetween(1, 4),
            'grade_id' => fake()->numberBetween(1, 17),
        ];
    }

    public function published(bool $value = true): Factory
    {
        return $this->state(function (array $attributes) use ($value) {
            return ['published'=> $value];
        });
    }

    public function accessibility(Accessibility $value = Accessibility::Public): Factory
    {
        return $this->state(function (array $attributes) use ($value) {
            return ['accessibility'=> $value];
        });
    }
}
