<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Test $test)
    {
        $data = $test->toArray();
        $data['questions'] = $test->questions->toArray();

        foreach ($data['questions'] as $question) {
            $question['text'] = clean($question['text']);

            foreach ($question['options'] as $option) {
                $option['text'] = clean($option['text']);
            }
        }

        if (($test->course)) $data['course'] = [
            ...$test->course->toArray(),
            'topics' => $test->course->topics->toArray(),
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'description' => ['string', 'nullable'],
            'course' => ['required', 'integer'],
            'subject' => ['required', 'integer'],
            'grade' => ['required', 'integer'],
        ]); 

        $test->name = $data['name'];
        $test->description = $data['description'];
        $test->subject_id = $data['subject'];
        $test->grade_id = $data['grade'];

        $test['course_id'] = $data['course'] > 0 ? $data['course'] : null;

        $test->save();

        return response();
    }
}
