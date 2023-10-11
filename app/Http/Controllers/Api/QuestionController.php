<?php

namespace App\Http\Controllers\Api;

use App\Enums\QuestionType;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Test;
use App\Models\Option;
use App\Rules\Options;
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
            'image' => ['image', 'nullable', 'max:2048'],
            'points' => ['required', 'numeric'],
            'explanation' => ['string', 'nullable'],

            'register_matters' => ['boolean', 'nullable'],
            'whitespace_matters' => ['boolean', 'nullable'],
            'show_amount_of_correct' => ['boolean', 'nullable'],
        ]);
        $data['text'] = clean($data['text']);

        $imagePath = isset($data['image']) ? $request->file('image')->store('public/images') : null;

        $question = new Question([
            'type' => $data['type'],
            'text' => $data['text'],
            'image' => $imagePath,
            'points' => $data['points'],
            'explanation' => $data['explanation'] ?? null,
            'test_id' => $test->id,
        ]);

        $optionsData = $request->validate([
            'options' => ['required', new Options(QuestionType::from($data['type']))],
        ])['options'];

        $question->save();

        foreach ($optionsData as $optionData) {
            // TODO: Image uploading;
            $option = new Option([
                'question_id' => $question->id,
                'text' => $optionData['text'],
                'correct' => $optionData['correct'] ?? null,
                'group' => $optionData['group'] ?? null,
                'match_id' => $optionData['match_id'] ?? null,
                'sequence_index' => $optionData['sequence_index'] ?? null,
            ]);

            $option->save();
        }
        $question->load('options');

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
        $data = $request->validate([
            'type' => ['required', new Enum(QuestionType::class)],
            'text' => ['required', 'string'],
            'image' => ['image', 'nullable', 'max:2048'],
            'points' => ['required', 'numeric'],
            'explanation' => ['string', 'nullable'],

            'register_matters' => ['boolean', 'nullable'],
            'whitespace_matters' => ['boolean', 'nullable'],
            'show_amount_of_correct' => ['boolean', 'nullable'],
        ]);
        $data['text'] = clean($data['text']);

        // TODO: Remove image if updated
        $imagePath = isset($data['image']) ? $request->file('image')->store('public/images') : null;

        $question['type'] = $data['type'];
        $question['text'] = $data['text'];
        $question['image'] = $imagePath;
        $question['points'] = $data['points'];
        $question['explanation'] = $data['explanation'] ?? null;

        $question['register_matters'] = $data['register_matters'] ?? $question['register_matters'];
        $question['whitespace_matters'] = $data['whitespace_matters'] ?? $question['whitespace_matters'];
        $question['show_amount_of_correct'] = $data['show_amount_of_correct'] ?? $question['show_amount_of_correct'];

        $optionsData = $request->validate([
            'options' => ['required', new Options(QuestionType::from($data['type']))],
        ])['options'];

        $question->save();

        foreach ($question->options as $option) {
            $delete = true;
            foreach ($optionsData as $optionData) {
                if (isset($optionData['id']) && $option->id === intval($optionData['id'])) {
                    $delete = false;
                }
            }
            if ($delete) {
                $option->delete();
            }
        }

        foreach ($optionsData as $optionData) {
            // TODO: Image uploading;

            $option = isset($optionData['id']) ? $question->options->find($optionData['id']) : new Option([
                'question_id' => $question->id,
            ]);
            if (!$option) continue;

            $option['text'] = $optionData['text'];
            $option['correct'] = $optionData['correct'] ?? null;
            $option['group'] = $optionData['group'] ?? null;
            $option['match_id'] = $optionData['match_id'] ?? null;
            $option['sequence_index'] = $optionData['sequence_index'] ?? null;

            $option->save();
        }
        $question->load('options');

        return response()->json($question->toArray());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
    }
}
