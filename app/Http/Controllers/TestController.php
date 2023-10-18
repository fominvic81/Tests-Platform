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
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
