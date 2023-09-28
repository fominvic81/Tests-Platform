<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('test.index', [
            'tests' => Test::query()->latest('id')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('test.create', [
            'subjects' => Subject::all(),
            'grades' => Grade::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'description' => [],
            'course' => ['integer'],
            'subject' => ['integer'],
            'grade' => ['integer'],
        ]);

        $test = new Test([
            'name' => $data['name'],
            'description' => $data['description'],
            'user_id' => $request->user()->id,
        ]);

        if ($data['course'] > 0) $test['course_id'] = $data['course'];
        if ($data['subject'] > 0) $test['subject_id'] = $data['subject'];
        if ($data['grade'] > 0) $test['grade_id'] = $data['grade'];

        $test->save();

        return redirect()->route('test.edit', $test->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Test $test)
    {
        return view('test.show', [ 'test' => $test ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        return view('test.edit', [ 'test' => $test ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
