<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ImageHelper;
use App\Helpers\QuestionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Test;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request, Test $test)
    {
        $data = $request->validated();
        $data['data'] = QuestionHelper::parse($data['data']);

        $data['image'] = isset($variant['image']) ? ImageHelper::uploadImage($data['image']) : null;

        $question = new Question($data);
        $question->test()->associate($test);
        $question->save();

        return response()->json($question->makeHidden('test')->toArray());
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
    public function update(QuestionRequest $request, Question $question)
    {
        $data = $request->validated();
        $data['data'] = QuestionHelper::parse($data['data'], $question->data);

        $deleteImage = boolval($data['del_image'] ?? null);
        $data['image'] = isset($variant['image']) ? ImageHelper::uploadImage($data['image']) :
            ($deleteImage ? null : ($question['image'] ?? null));

        $question->fill($data);
        $question->save();

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
