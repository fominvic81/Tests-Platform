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
            case QuestionType::MultipleCorrect:
                $result = Validator::make($value, [
                    'showAmountOfCorrect' => $this->type === QuestionType::MultipleCorrect ? ['required', 'boolean'] : [],
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*' => ['array:text,image,correct'],
                    'options.*.text' => ['required', 'string'],
                    'options.*.image' => ['string'],
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
                    'options.*' => ['array:text,image'],
                    'options.*.text' => ['required', 'string'],
                    'options.*.image' => ['string'],
                    
                    'variants' => ['required', 'array', 'between:2,20'],
                    'variants.*' => ['array:text,image'],
                    'variants.*.text' => ['required', 'string'],
                    'variants.*.image' => ['string'],

                    'matchTable' => ['required', 'array', 'between:2,20'],
                    'matchTable.*' => ['integer'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();

                break;
            case QuestionType::TextInput:
                $result = Validator::make($value, [
                    'registerMatters' => ['required', 'boolean'],
                    'whitespaceMatters' => ['required', 'boolean'],
                    'options' => ['required', 'array', 'between:1,20'],
                    'options.*' => ['string'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();

                break;
            case QuestionType::Sequense:
                $result = Validator::make($value, [
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*' => ['array:text,image,index'],
                    'options.*.text' => ['required', 'string'],
                    'options.*.image' => ['string'],
                    'options.*.index' => ['required', 'integer'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();
                $optionsSize = count($data['options']);

                $flags = array_fill(0, $optionsSize, false);
                $count = 0;
                foreach ($data['options'] as $option) {
                    $index = $option['index'];
                    if ($index < 0 || $index >= $optionsSize) {
                        $fail('Не коректна послідовність елементів');
                        break 2;
                    }
                    if (!$flags[$index]) {
                        $flags[$index] = true;
                        ++$count;
                    }
                }
                if ($count != $optionsSize) {
                    $fail('Не коректна послідовність елементів');
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
