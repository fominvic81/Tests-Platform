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
use Mews\Purifier\Facades\Purifier;

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

        $optionsData = $request->validate([
            'options' => ['required', new Options(QuestionType::from($data['type']))],
        ])['options'];

        $imagePath = isset($data['image']) ? $data['image']->store('public/images') : null;

        $question = new Question([
            'type' => $data['type'],
            'text' => $data['text'],
            'image' => $imagePath,
            'points' => $data['points'],
            'explanation' => $data['explanation'] ?? null,
            'test_id' => $test->id,
        ]);

        $question->save();

        $options = [];
        foreach ($optionsData as $optionData) {

            $optionImagePath = isset($optionData['image']) ? $optionData['image']->store('public/images') : null;

            $option = new Option([
                'question_id' => $question->id,
                'text' => $optionData['text'],
                'image' => $optionImagePath,
                'correct' => $optionData['correct'] ?? null,
                'group' => $optionData['group'] ?? null,
                'match_id' => null,
                'sequence_index' => $optionData['sequence_index'] ?? null,
            ]);

            $option->save();

            array_push($options, $option);
        }

        foreach ($optionsData as $i => $optionDataA) {
            if (!isset($optionDataA['match_id'])) continue;

            foreach ($optionsData as $j => $optionDataB) {
                if ($optionDataA['match_id'] === $optionDataB['id']) {
                    $options[$i]['match_id'] = $options[$j]['id'];
                    $options[$i]->save();
                    break;
                }
            }
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
            'delete_image' => ['required', 'boolean'],
            'points' => ['required', 'numeric'],
            'explanation' => ['string', 'nullable'],

            'register_matters' => ['boolean', 'nullable'],
            'whitespace_matters' => ['boolean', 'nullable'],
            'show_amount_of_correct' => ['boolean', 'nullable'],
        ]);

        $optionsData = $request->validate([
            'options' => ['required', new Options(QuestionType::from($data['type']))],
        ])['options'];

        // TODO: Remove image if updated
        $imagePath =
            (boolval($data['delete_image'] ?? null)) ? null :
            (isset($data['image']) ? $data['image']->store('public/images') :
            $question['image']);

        $question['type'] = $data['type'];
        $question['text'] = $data['text'];
        $question['image'] = $imagePath;
        $question['points'] = $data['points'];
        $question['explanation'] = $data['explanation'] ?? null;

        $question['register_matters'] = $data['register_matters'] ?? $question['register_matters'];
        $question['whitespace_matters'] = $data['whitespace_matters'] ?? $question['whitespace_matters'];
        $question['show_amount_of_correct'] = $data['show_amount_of_correct'] ?? $question['show_amount_of_correct'];

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

        $options = [];
        foreach ($optionsData as $optionData) {

            $option = $question->options->find($optionData['id']) ?? new Option(['question_id' => $question->id]);
            array_push($options, $option);

            $optionImagePath =
                (boolval($optionData['delete_image'] ?? null)) ? null :
                (isset($optionData['image']) ? $optionData['image']->store('public/images') :
                $option['image']);

            $option['text'] = $optionData['text'];
            $option['image'] = $optionImagePath;
            $option['correct'] = $optionData['correct'] ?? null;
            $option['group'] = $optionData['group'] ?? null;
            $option['match_id'] = null;
            $option['sequence_index'] = $optionData['sequence_index'] ?? null;

            $option->save();
        }

        foreach ($optionsData as $i => $optionDataA) {
            if (!isset($optionDataA['match_id'])) continue;

            foreach ($optionsData as $j => $optionDataB) {
                if ($optionDataA['match_id'] === $optionDataB['id']) {
                    $options[$i]['match_id'] = $options[$j]['id'];
                    $options[$i]->save();
                    break;
                }
            }
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
