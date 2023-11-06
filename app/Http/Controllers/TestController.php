<?php

namespace App\Http\Controllers;

use App\Enums\Accessibility;
use App\Helpers\ImageHelper;
use App\Http\Requests\TestRequest;
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
            'tests' => Test::query()
                ->where('published', '=', true)
                ->where('accessibility', '=', Accessibility::Public)
                ->latest('id')
                ->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('test.create', [
            'courses' => $request->user()->courses,
            'subjects' => Subject::all(),
            'grades' => Grade::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestRequest $request)
    {
        $data = $request->validated();

        $data['image'] = isset($data['image']) ? ImageHelper::uploadImage($data['image']) : null;

        $test = new Test($data);

        $test->user()->associate($request->user());
        $test->course()->associate($data['course']);
        $test->subject()->associate($data['subject']);
        $test->grade()->associate($data['grade']);

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
        return view('test.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
