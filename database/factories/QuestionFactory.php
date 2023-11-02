<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => QuestionType::OneCorrect,
            'text' => fake()->text(),
            'image' => null,
            'points' => fake()->numberBetween(1, 5),
            'explanation' => null,
            'data' => null,
        ];
    }

    public function type(QuestionType $type): Factory
    {
        return $this->state(function (array $attributes) use ($type) {
            return [
                'type'=> $type,
            ];
        });
    }

    public function text(string $text): Factory
    {
        return $this->state(function () use ($text) {
            return [
                'text' => $text,
            ];
        });
    }

    public function points(int $points): Factory
    {
        return $this->state(function () use ($points) {
            return [
                'points'=> $points,
            ];
        });
    }

    public function data(array $data): Factory
    {
        return $this->state(function () use ($data) {
            return [
                'data'=> $data,
            ];
        });
    }
}
