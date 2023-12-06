<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\Test;
use App\Models\TestingSession;
use App\Models\TestingSessionSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('exam.index', [
            'exams' => $request->user()->exams()->latest('id')->paginate(20),
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
    public function store(Test $test, ExamRequest $request)
    {
        $data = $request->validated();
        $data['begin_at'] = Carbon::parse($data['begin_at'], config('app.timezone_client'))->setTimezone(config('app.timezone'));
        $data['end_at'] = Carbon::parse($data['end_at'], config('app.timezone_client'))->setTimezone(config('app.timezone'));
        $data['time'] = $data['time'] ?? null;

        $settings = new TestingSessionSettings($data);
        $settings->save();

        $code = 0;
        do {
            $code = mt_rand(1000000, 9999999);
        } while (Exam::query()->where('code', '=', $code)->notEnded()->count() > 0);

        $exam = new Exam($data);
        $exam->code = $code;
        $exam->test()->associate($test);
        $exam->settings()->associate($settings);
        $exam->user()->associate($request->user());
        
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
            'test' => $exam->test,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExamRequest $request, Exam $exam)
    {
        // TODO: check if exam has ended

        $data = $request->validated();
        $data['begin_at'] = Carbon::parse($data['begin_at'], config('app.timezone_client'))->setTimezone(config('app.timezone'));
        $data['end_at'] = Carbon::parse($data['end_at'], config('app.timezone_client'))->setTimezone(config('app.timezone'));
        $data['time'] = $data['time'] ?? null;

        $exam->settings->fill($data);
        $exam->settings->save();
        
        $exam = $exam->fill($data);
        $exam->save();

        return redirect()->route('exam.show', $exam->id);
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
        $this->authorize('create', TestingSession::class);
        return view('exam.join', [
            'code' => $request->query('code'),
        ]);
    }

    public function start(Request $request)
    {
        $this->authorize('create', TestingSession::class);
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'code' => ['required', 'integer', 'digits:7'],
        ]);

        $exam = Exam::query()->withoutGlobalScope('allowed')->where('code', '=', $data['code'])->notEnded()->first();

        if (!$exam) return redirect()->back()->withInput()->withErrors('Тест таким кодом не знайдено');
        if (!$exam->hasBegun()) return redirect()->back()->withInput()->withErrors('Тест ще не почався');

        $session = new TestingSession([
            'student_name' => $data['name'],
        ]);

        $session->exam()->associate($exam);
        $session->test()->associate($exam->test);
        $session->settings()->associate($exam->settings);
        $session->user()->associate($request->user());

        $session->ends_at = $exam->settings->time ? now()->addSeconds(strtotime($exam->settings->time, 0)) : null;

        $session->save();

        return redirect()->route('testing.show', $session->id);
    }
}
