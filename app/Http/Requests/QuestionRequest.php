<?php

namespace App\Http\Requests;

use App\Enums\QuestionType;
use App\Helpers\Question\QuestionHelper;
use App\Rules\QuestionData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rules\Enum;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', new Enum(QuestionType::class)],
            'text' => ['required', 'string', 'max:10000'],
            'image' => ['image', 'nullable', 'max:10240'],
            'del_image' => ['nullable', 'boolean'],
            'points' => ['required', 'integer'],
            'explanation' => ['nullable', 'string'],
            'data' => ['required', new QuestionData()],
        ];
    }
}
