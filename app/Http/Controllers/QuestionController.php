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
        return view('question.create', ['test' => $test]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Test $test)
    {
        $data = $request->validate([
            'type' => ['required', new Enum(QuestionType::class)],
            'text' => ['required', 'string'],
            'image' => ['image', 'nullable', 'max:2048'],
            'points' => ['required', 'numeric'],
            'explanation' => ['string', 'nullable'],
        ]);
        $data['text'] = clean($data['text']);

        $questionData = $request->validate([
            'data' => ['required', 'array', new Option(QuestionType::from($request->post('type')))],
        ])['data'];

        $imagePath = isset($data['image']) ? $request->file('image')->store('public/images') : null;

        $question = new Question([
            'type' => $data['type'],
            'text' => $data['text'],
            'image' => $imagePath,
            'data' => $questionData,
            'points' => $data['points'],
            'explanation' => $data['explanation'] ?? null,
            'test_id' => $test->id,
        ]);

        $question->save();

        return redirect()->to(route('test.edit', $test->id));
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
        $question->delete();
        return redirect()->back();
    }
}
