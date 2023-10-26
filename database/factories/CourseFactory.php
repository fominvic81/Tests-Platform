<?php

namespace Database\Factories;

use App\Enums\Accessibility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
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
            'name' => fake()->company(),
            'description' => fake()->text(),
            'published' => fake()->boolean(90),
            'accessibility' => fake()->randomElement(Accessibility::cases()),
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
