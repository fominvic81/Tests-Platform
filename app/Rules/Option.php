<?php

namespace App\Rules;

use App\Enums\QuestionType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class Option implements ValidationRule
{

    public QuestionType $type;

    public function __construct(QuestionType $type)
    {
        $this->type = $type;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = Validator::make([], []);
        $result = null;

        switch ($this->type) {
            case QuestionType::OneCorrect:
            case QuestionType::MultipleCorrectAmountHidden:
            case QuestionType::MultipleCorrectAmountShown:
                $result = Validator::make($value, [
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*.text' => ['required', 'string'],
                    'options.*.correct' => ['required', 'boolean'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();

                if (count($data['options']) <= 1) {
                    $fail('Має бути хоча б два варіанти відповіді');
                }
                
                $amountOfCorrect = 0;
                foreach ($data['options'] as $option) {
                    if ($option['correct']) ++$amountOfCorrect;
                }
                if ($amountOfCorrect === 0) $fail('Виберіть правильний варіант');
                if ($amountOfCorrect > 1 && $this->type === QuestionType::OneCorrect) $fail('Має бути тільки один правильний варіант');

                break;
            case QuestionType::Match:
                $result = Validator::make($value, [
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*' => ['string'],

                    'variants' => ['required', 'array', 'between:2,20'],
                    'variants.*' => ['string'],

                    'matchTable' => ['required', 'array', 'between:2,20'],
                    'matchTable.*' => ['numeric'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();

                break;
            case QuestionType::TextInput:
                $result = Validator::make($value, [
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*' => ['string'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();

                break;
            case QuestionType::Sequense:
                $result = Validator::make($value, [
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*.text' => ['required', 'string'],
                    'options.*.index' => ['required', 'numeric'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();

                foreach ($data['options'] as $option) {
                    
                }

                break;

        }

        if (!$result) {
            $fail('Невідомий тип завдання');
            return;
        }

        if (!$result->passes()) $fail($result->messages()->first());
    }
}