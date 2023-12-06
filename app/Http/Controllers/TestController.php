<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\TestRequest;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TestController extends Controller
{

    private function indexQuery(Request $request, string $title, Builder $query)
    {
        $subject = $request->query('subject');
        $grade = $request->query('grade');
        if ($subject) $query->where('subject_id', $subject);
        if ($grade) $query->where('grade_id', $grade);

        return view('test.index', [
            'title'=> $title,
            'tests'=> $query->latest('tests.id')->paginate(15),
            'subjects' => Subject::all(),
            'grades' => Grade::all(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->indexQuery($request, 'Тести', Test::query());
    }

    public function my(Request $request)
    {
        return $this->indexQuery($request, 'Мої тести', Test::query()->whereBelongsTo($request->user()));
    }

    public function saved(Request $request)
    {
        return $this->indexQuery($request, 'Збережені тести', Test::query()->whereRelation('savedBy', 'user_id', $request->user()->id));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Test::class);
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
        $this->authorize('create', Test::class);
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
        $this->authorize('update', $test);
        return view('test.edit', [
            'test' => $test,
        ]);
    }

    public function publish(Test $test)
    {
        $test->published = true;
        $test->save();
        return redirect()->route('test.show', $test->id);
    }

    public function save(Request $request, Test $test)
    {
        $data = $request->validate(['value' => ['required', 'boolean']]);

        if ($data['value']) {
            $request->user()->savedTests()->attach($test);
        } else {
            $request->user()->savedTests()->detach($test);
        }
        return response('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        $this->authorize('delete', $test);
        $test->delete();
    }
}
