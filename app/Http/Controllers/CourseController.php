<?php

namespace App\Http\Controllers;

use App\Enums\Accessibility;
use App\Helpers\ImageHelper;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('course.index', [
            'courses' => Course::query()
                ->where('published', '=', true)
                ->where('accessibility', '=', Accessibility::Public)
                ->latest('id')
                ->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        return view('course.edit', [ 'course' => $course ]);
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validated();

        $data['image'] =
            (boolval($data['del_image'] ?? null)) ? null :
            (isset($data['image']) ? ImageHelper::uploadImage($data['image']) :
            $course->image);

        $course->fill($data);
        $course->save();

        $course->save();

        return redirect()->route('course.show', $course->id);
    }
}
