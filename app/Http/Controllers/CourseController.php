<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private function indexQuery(Request $request, string $title, Builder $query)
    {
        $subject = $request->query('subject');
        $grade = $request->query('grade');
        if ($subject) $query->where('subject_id', $subject);
        if ($grade) $query->where('grade_id', $grade);

        return view('course.index', [
            'title'=> $title,
            'courses'=> $query->latest('courses.id')->paginate(),
            'subjects' => Subject::all(),
            'grades' => Grade::all(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->indexQuery($request, 'Курси', Course::query());
    }

    public function my(Request $request)
    {
        return $this->indexQuery($request, 'Мої курси', Course::query()->whereBelongsTo($request->user()));
    }

    public function saved(Request $request)
    {
        return $this->indexQuery($request, 'Збережені курси', Course::query()->whereRelation('savedBy', 'user_id', $request->user()->id));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Course::class);
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $this->authorize('create', Course::class);
        $data = $request->validated();

        $data['image'] = isset($data['image']) ? ImageHelper::uploadImage($data['image']) : null;

        $course = new Course($data);
        $course->published = false;
        $course->user()->associate($request->user());

        $course->save();

        return redirect()->route('course.show', $course->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('course.show', [ 'course' => $course ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('course.edit', [ 'course' => $course ]);
    }

    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);
        $data = $request->validated();

        $data['image'] =
            (boolval($data['del_image'] ?? null)) ? null :
            (isset($data['image']) ? ImageHelper::uploadImage($data['image']) :
            $course->image);

        $course->fill($data);
        $course->save();

        return redirect()->route('course.show', $course->id);
    }

    public function save(Request $request, Course $course)
    {
        $data = $request->validate(['value' => ['required', 'boolean']]);

        if ($data['value']) {
            $request->user()->savedCourses()->attach($course);
        } else {
            $request->user()->savedCourses()->detach($course);
        }
        return response('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();
        return redirect()->route('course.index');
    }
}
