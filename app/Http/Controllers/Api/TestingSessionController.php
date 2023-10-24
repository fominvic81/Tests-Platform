<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TestingSession;
use Illuminate\Http\Request;

class TestingSessionController extends Controller
{
    public function index()
    {
        //
    }

    public function show(TestingSession $session)
    {
        // $questions = [];

        // foreach ($session->test->questions as $question) {
            
        //     $options = $question->options;

        //     if ($session->settings->shuffle_options) $options->shuffle();

        //     array_push($questions, [
        //         'type'
        //         'text'
        //         'image'
        //         'points'
        //         'explanation'
        //         'test_id'
        //         'register_matters'
        //         'whitespace_matters'
        //         'show_amount_of_correct'
        //     ]);

        // }

        $questions = $session->test->questions;
        $data = [
            'questions' => $questions,
        ];

        return response()->json($data);
    }

    
}
