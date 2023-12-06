<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestRequest;
use App\Models\Test;

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
        return response()->json([
            ...$test->toArray(),
            'course' => $test->course,
            'questions' => $test->questions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestRequest $request, Test $test)
    {
        $this->authorize('update', $test);
        $data = $request->validated();

        $data['image'] =
            (boolval($data['del_image'] ?? null)) ? null :
            (isset($data['image']) ? ImageHelper::uploadImage($data['image']) :
            $test['image']);

        $test->fill($data);

        $test->subject()->associate($data['subject']);
        $test->grade()->associate($data['grade']);
        $test->course()->associate($data['course']);

        $test->save();
        $test->load(['grade', 'subject']);

        return response()->json([
            ...$test->toArray(),
            'course' => $test->course,
            'questions' => $test->questions,
        ]);
    }
}
