<?php

namespace App\Rules;

use App\Enums\QuestionType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class Options implements ValidationRule
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
        $valueToValidate = ['options' => $value];

        $result = Validator::make([], []);
        $result = null;

        switch ($this->type) {
            case QuestionType::OneCorrect:
            case QuestionType::MultipleCorrect:
                $result = Validator::make($valueToValidate, [
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*' => ['array:id,text,image,delete_image,correct'],
                    'options.*.id' => ['nullable', 'integer'],
                    'options.*.text' => ['required', 'string'],
                    'options.*.image' => ['nullable', 'image', 'max:2048'],
                    'options.*.delete_image' => ['required', 'boolean'],
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
                $result = Validator::make($valueToValidate, [
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*' => ['array:id,text,image,delete_image,variant_id,match_id'],
                    'options.*.id' => ['nullable', 'integer'],
                    'options.*.text' => ['required', 'string'],
                    'options.*.image' => ['nullable', 'image', 'max:2048'],
                    'options.*.delete_image' => ['required', 'boolean'],
                    'options.*.variant_id' => ['nullable', 'integer'],
                    'options.*.match_id' => ['nullable', 'integer'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();

                break;
            case QuestionType::TextInput:
                $result = Validator::make($valueToValidate, [
                    'options' => ['required', 'array', 'between:1,20'],
                    'options.*' => ['array:id,text'],
                    'options.*.id' => ['nullable', 'integer'],
                    'options.*.text' => ['required', 'string'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();

                break;
            case QuestionType::Sequence:
                $result = Validator::make($valueToValidate, [
                    'options' => ['required', 'array', 'between:2,20'],
                    'options.*' => ['array:id,text,image,delete_image,sequence_index'],
                    'options.*.id' => ['nullable', 'integer'],
                    'options.*.text' => ['required', 'string'],
                    'options.*.image' => ['nullable', 'image', 'max:2048'],
                    'options.*.delete_image' => ['required', 'boolean'],
                    'options.*.sequence_index' => ['required', 'integer'],
                ]);
                if (!$result->passes()) break;
                $data = $result->validated();
                $optionsSize = count($data['options']);

                $flags = array_fill(0, $optionsSize, false);
                $count = 0;
                foreach ($data['options'] as $option) {
                    $index = intval($option['sequence_index']);
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
