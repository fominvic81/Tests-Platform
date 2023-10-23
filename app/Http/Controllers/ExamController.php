<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Test;
use App\Models\TestingSessionSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('exam.index', [
            'exams' => $request->user()->exams()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Test $test)
    {
        return view('exam.create', [
            'test' => $test,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Test $test, Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'begin' => ['required', 'date_format:Y-m-d\\TH:i'],
            'end' => ['required', 'date_format:Y-m-d\\TH:i'],

            'points_min' => ['required', 'integer'],
            'points_max' => ['required', 'integer'],
            'time' => ['required', 'date_format:H:i'],
            'shuffle_questions' => ['nullable', 'boolean'],
            'shuffle_options' => ['nullable', 'boolean'],
            'show_result' => ['nullable', 'boolean'],
        ]);
        $data['shuffle_questions'] = boolval($data['shuffle_questions'] ?? null);
        $data['shuffle_options'] = boolval($data['shuffle_options'] ?? null);
        $data['show_result'] = boolval($data['show_result'] ?? null);

        $settings = new TestingSessionSettings([
            'points_min' => $data['points_min'],
            'points_max' => $data['points_max'],
            'time' => $data['time'],
            'shuffle_questions' => $data['shuffle_questions'],
            'shuffle_options' => $data['shuffle_options'],
            'show_result' => $data['show_result'],
        ]);

        $settings->save();

        $code = 0;
        do {
            $code = mt_rand(1000000, 9999999);
        } while (Exam::query()->where('code', '=', $code)->count() > 0);

        $exam = new Exam([
            'label' => $data['label'],
            'begin_at' => $data['begin'],
            'end_at' => $data['end'],
            'code' => $code,
            'test_id' => $test->id,
            'testing_session_settings_id' => $settings->id,
            'user_id' => $request->user()->id,
        ]);

        $exam->save();

        return redirect()->route('exam.show', $exam->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        return view('exam.show', [
            'exam'=> $exam,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        return view('exam.edit', [
            'exam' => $exam,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        //
    }
}
