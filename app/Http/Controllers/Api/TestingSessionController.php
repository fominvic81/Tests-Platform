<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Timezone;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\TestingSession;

class TestingSessionController extends Controller
{

    public function show(TestingSession $session)
    {
        $questions = [];

        foreach ($session->test->questions as $question) {

            $answer = Answer::query()->whereBelongsTo($session, 'session')->whereBelongsTo($question)->first();

            $q = $question->toArray();
            $q['data']['answer'] = $answer ? $answer->data : null;

            array_push($questions, $q);
        }

        $data = [
            'id' => $session->id,
            'ends_at' => $session->ends_at ? Timezone::getDatetime($session->ends_at)->timestamp : null,
            'questions' => $questions,
        ];

        return response()->json($data);
    }
}
