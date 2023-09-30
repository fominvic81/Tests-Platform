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
            'name' => ['required', 'string', 'min:3'],
            'description' => ['string', 'nullable'],
            'course' => ['integer'],
            'subject' => ['integer'],
            'grade' => ['integer'],
        ]);

        $test = new Test([
            'name' => $data['name'],
            'description' => $data['description'],
            'user_id' => $request->user()->id,
            'subject_id' => $data['subject'],
            'grade_id' => $data['grade'],
        ]);

        if ($data['course'] > 0) $test['course_id'] = $data['course'];

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
        return view('test.edit', [
            'test' => $test,
            'subjects' => Subject::all(),
            'grades' => Grade::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'description' => ['string', 'nullable'],
            'course' => ['integer'],
            'subject' => ['integer'],
            'grade' => ['integer'],
        ]); 

        $test->name = $data['name'];
        $test->description = $data['description'];
        $test->subject_id = $data['subject'];
        $test->grade_id = $data['grade'];

        $test['course_id'] = $data['course'] > 0 ? $data['course'] : null;

        $test->save();

        return redirect()->refresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
