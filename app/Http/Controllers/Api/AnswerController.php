<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AnswerChecker;
use App\Helpers\QuestionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\TestingSession;

class AnswerController extends Controller
{
    
    public function store(AnswerRequest $request, TestingSession $session)
    {
        $data = $request->validated();
        $data['answer'] = QuestionHelper::parseAnswer($data['answer']);

        $question = $request->question;

        if (!$question) return response(null, 404);
        if (!$session->test->questions()->find($question->id)) return response(null, 403);

        $points = AnswerChecker::check($question->type, $data['answer'], $question->data) * $question->points;

        $answer = Answer::query()->whereBelongsTo($session, 'session')->whereBelongsTo($question)->first();

        if (!$answer) {
            $answer = new Answer();

            $answer->session()->associate($session);
            $answer->question()->associate($question);
        }

        $answer->points = $points;
        $answer->data = $data['answer'];

        $answer->save();

        return response()->json($data['answer']);
    }

}
