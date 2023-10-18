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

        $data['course'] = $test->course;
        $data['questions'] = $test->questions;

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'image' => ['nullable', 'image', 'max:2048'],
            'delete_image' => ['required', 'boolean'],
            'description' => ['string', 'nullable'],
            'course' => ['required', 'integer'],
            'subject' => ['required', 'integer'],
            'grade' => ['required', 'integer'],
        ]);

        $imagePath = isset($data['image']) ? $data['image']->store('public/images') : null;

        $test = new Test([
            'name' => $data['name'],
            'image' => $imagePath,
            'description' => $data['description'],
            'user_id' => $request->user()->id,
            'subject_id' => $data['subject'],
            'grade_id' => $data['grade'],
        ]);

        if ($data['course'] > 0) $test['course_id'] = $data['course'];
        $test->load(['subject', 'grade']);

        $test->save();

        return response()->json($test->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'image' => ['nullable', 'image', 'max:2048'],
            'delete_image' => ['required', 'boolean'],
            'description' => ['string', 'nullable'],
            'course' => ['required', 'integer'],
            'subject' => ['required', 'integer'],
            'grade' => ['required', 'integer'],
        ]);

        $imagePath =
            (boolval($data['delete_image'] ?? null)) ? null :
            (isset($data['image']) ? $data['image']->store('public/images') :
            $test['image']);

        $test->name = $data['name'];
        $test->image = $imagePath;
        $test->description = $data['description'];
        $test->subject_id = $data['subject'];
        $test->grade_id = $data['grade'];

        $test['course_id'] = $data['course'] > 0 ? $data['course'] : null;

        $test->save();

        return response()->json($test->toArray());
    }
}
