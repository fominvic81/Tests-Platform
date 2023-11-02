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
        if (!$value) return;

        $result = Validator::make($value, QuestionHelper::getAnswerRulesByType($this->type));

        if ($result->fails()) {
            foreach ($result->errors()->all() as $error) $fail($error);
            return;
        }

        //
    }
}
