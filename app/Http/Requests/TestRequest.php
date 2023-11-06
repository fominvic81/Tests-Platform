<?php

namespace App\Http\Requests;

use App\Enums\Accessibility;
use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $course_id = $this->get('course');
        if (!$course_id) return true;

        $course = Course::query()->find($course_id);
        return $this->user()->id === $course->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'image' => ['nullable', 'image', 'max:2048'],
            'del_image' => ['required', 'boolean'],
            'accessibility' => ['required', new Enum(Accessibility::class)],
            'description' => ['string', 'nullable'],
            'course' => ['nullable', 'integer', 'exists:courses,id'],
            'subject' => ['required', 'integer', 'exists:subjects,id'],
            'grade' => ['required', 'integer', 'exists:grades,id'],
        ];
    }
}
