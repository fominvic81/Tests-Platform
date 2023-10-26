<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text(),
            'image' => null,
            // 'group',
        ];
    }

    public function text(string $text): Factory
    {
        return $this->state(function () use ($text) {
            return [
                'text' => $text,
            ];
        });
    }

    public function correct(bool $correct): Factory
    {
        return $this->state(function () use ($correct) {
            return [
                'correct' => $correct,
            ];
        });
    }

    public function match(bool $isVariant, int $id): Factory
    {
        return $this->state(function () use ($isVariant, $id) {
            return $isVariant ? [
                'variant_id' => $id,
            ] : [
                'match_id' => $id,
            ];
        });
    }

    public function seq(int $index): Factory
    {
        return $this->state(function () use ($index) {
            return [
                'sequence_index'=> $index,
            ];
        });
    }

}
