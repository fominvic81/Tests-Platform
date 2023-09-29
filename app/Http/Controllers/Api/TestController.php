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
        //
    }
}
