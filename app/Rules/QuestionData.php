<?php

namespace App\Rules;

use App\Enums\QuestionType;
use App\Helpers\QuestionHelper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\Validator;

class QuestionData implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
 
        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) return;
        $type = QuestionType::from($this->data['type']);

        $result = Validator::make($value, QuestionHelper::getRulesByType($type))->stopOnFirstFailure();

        if ($result->fails()) {
            foreach ($result->errors()->all() as $error) $fail($error);
            return;
        }

        //

    }
}
