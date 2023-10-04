<?php

namespace App\Http\Controllers\Api;

use App\Enums\QuestionType;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Test;
use App\Rules\Option;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Test $test)
    {
        $data = $request->validate([
            'type' => ['required', new Enum(QuestionType::class)],
            'text' => ['required', 'string'],
            'points' => ['required', 'numeric'],
            'explanation' => ['string', 'nullable'],
        ]);

        $questionData = $request->validate([
            'data' => ['required', 'array', new Option(QuestionType::from($request->post('type')))],
        ])['data'];

        $question = new Question([
            'type' => $data['type'],
            'text' => $data['text'],
            'data' => $questionData,
            'points' => $data['points'],
            'explanation' => $data['explanation'] ?? null,
            'test_id' => $test->id,
        ]);

        $question->save();

        return response()->json($question->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return response()->json($question->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
    }
}
