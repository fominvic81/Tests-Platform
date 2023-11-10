<?php

namespace App\Http\Requests;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\TestingSession;
use App\Models\User;
use App\Rules\AnswerData;
use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(User $user): bool
    {
        $session = $this->route('session');
        if ($session->hasEnded()) return false;
        if ($session->user && $session->user->id !== $this->user()->id) return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $questionId = $this->request->getInt('question_id');
        $question = Question::query()->find($questionId);
        $this->request->set('question', $question);

        $type = $question ? $question->type : QuestionType::OneCorrect;

        return [
            'question_id' => ['required', 'integer'],
            'answer' => ['required_with:question_id', new AnswerData($type)],
        ];
    }
}
