<?php

namespace App\Http\Controllers;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Test;
use App\Rules\Option;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Test $test)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Test $test)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
