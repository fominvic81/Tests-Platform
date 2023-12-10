<?php

namespace App\Rules;

use App\Enums\QuestionType;
use App\Helpers\QuestionHelper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class AnswerData implements ValidationRule
{
    private QuestionType $type;
    private array $data;

    public function __construct(QuestionType $type, array $questionData)
    {
        $this->type = $type;
        $this->data = $questionData;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) return;

        $result = Validator::make($value, QuestionHelper::getAnswerRulesByType($this->type));

        if ($result->fails()) {
            foreach ($result->errors()->all() as $error) $fail($error);
            return;
        }

        switch ($this->type) {
            case QuestionType::OneCorrect:
            case QuestionType::MultipleCorrect:
                if (count($value['correct']) !== count($this->data['options'])) {
                    $fail('Щось пішло не так');
                    break;
                }
                $correct = 0;
                foreach ($value['correct'] as $isCorrect) if ($isCorrect) ++$correct;
                if ($this->type === QuestionType::MultipleCorrect && $this->data['settings']['showAmountOfCorrect']) {
                    $amountOfCorrect = count(array_keys($this->data['answer']['correct'], true));
                    if (count(array_keys($value['correct'], true)) !== $amountOfCorrect) {
                        $fail("Виберіть $amountOfCorrect " . (($amountOfCorrect % 10 >= 5 || $amountOfCorrect % 10 === 0 || ($amountOfCorrect / 10) % 10 === 1) ? 'віповідей' : ($amountOfCorrect % 10 === 1 ? 'відповідь' : 'відповіді')));
                    }
                }
                if ($correct === 0) $fail('Виберіть хоча б одну відповідь');
                if ($this->type === QuestionType::OneCorrect && $correct > 1) $fail('Має бути лише одна правильна відповідь');
                break;
            case QuestionType::Match:
                $variantsCount = count($this->data['variants']);
                $optionsCount = count($this->data['options']);
                if (count($value['match']) !== $optionsCount) {
                    $fail('Щось пішло не так');
                    break;
                }
                $chosenCount = 0;
                $chosen = [];
                foreach ($value['match'] as $match) {
                    if ($match < -1 || $match >= $variantsCount) {
                        $fail('Щось пішло не так');
                        break 2;
                    }
                    if ($match != -1) {
                        ++$chosenCount;
                        if (isset($chosen[$match])) {
                            $fail('Відповіді не повинні перетинатися');
                            break;
                        }
                        $chosen[$match] = true;
                    }
                }
                if ($chosenCount != min($variantsCount, $optionsCount)) $fail('Поєднайте всі варіанти');

                break;
            case QuestionType::TextInput:
                break;
            case QuestionType::Sequence:
                $optionsCount = count($this->data['options']);
                if (count($value['sequence']) !== $optionsCount) {
                    $fail('Щось піщло не так');
                    break;
                }
                
                $flags = [];
                foreach($value['sequence'] as $index) {
                    if ($index < 0 || $index >= $optionsCount || isset($flags[$index])) {
                        $fail('Щось піщло не так');
                        break 2;
                    }
                    $flags[$index] = true;
                }

                break;
        }
    }
}
