<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Test $test)
    {
        return response()->json([
            ...$test->toArray(),
            'questions' => $test->questions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'description' => [],
        ]);

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
