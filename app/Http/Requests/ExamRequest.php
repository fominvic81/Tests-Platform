<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            'label' => ['required', 'string', 'max:255'],
            'begin_at' => ['required', 'date_format:Y-m-d\\TH:i'],
            'end_at' => ['required', 'date_format:Y-m-d\\TH:i'],

            'points_min' => ['required', 'integer'],
            'points_max' => ['required', 'integer'],
            'time' => ['nullable', 'date_format:H:i'],
            'shuffle_questions' => ['required', 'boolean'],
            'shuffle_options' => ['required', 'boolean'],
            'show_result' => ['required', 'boolean'],
            'show_answers' => ['required', 'boolean'],
        ];
    }
}
