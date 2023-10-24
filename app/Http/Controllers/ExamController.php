<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Test;
use App\Models\TestingSession;
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
        } while (Exam::query()->where('code', '=', $code)->where('end_at', '>', now())->count() > 0);

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

    public function join(Request $request)
    {
        return view('exam.join', [
            'code' => $request->query('code'),
        ]);
    }

    public function start(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'code' => ['required', 'integer', 'digits:7'],
        ]);

        $exam = Exam::query()->where('code', '=', $data['code'])->where('end_at', '>', now())->first();

        if (!$exam) {
            return redirect()->back()->withInput()->withErrors('Тест таким кодом не знайдено');
        }

        $session = new TestingSession([
            'student_name' => $data['name'],
            'exam_id' => $exam->id,
            'test_id' => $exam->test->id,
            'testing_session_settings_id' => $exam->settings->id,
            'user_id' => $request->user()?->id,
        ]);

        $session->save();

        return redirect()->route('testing.show', $session->id);
    }
}
