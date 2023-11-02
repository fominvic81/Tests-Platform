<?php

namespace App\Http\Controllers\Api;

use App\Enums\Accessibility;
use App\Http\Controllers\Controller;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'image' => ['image', 'nullable', 'max:2048'],
            'accessibility' => ['required', new Enum(Accessibility::class)],
            'description' => ['nullable', 'string'],
        ]);

        $imagePath = isset($data['image']) ? $data['image']->store('public/images') : null;

        $course = new Course([
            'name' => $data['name'],
            'image' => $imagePath,
            'accessibility' => $data['accessibility'],
            'description' => $data['description'] ?? null,
            'user_id' => $request->user()->id,
        ]);

        $course->save();

        return response()->json($course->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return response()->json($course->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'image' => ['image', 'nullable', 'max:2048'],
            'del_image' => ['required', 'boolean'],
            'accessibility' => ['required', new Enum(Accessibility::class)],
            'description' => ['nullable', 'string'],
        ]);

        $imagePath =
            (boolval($data['del_image'] ?? null)) ? null :
            (isset($data['image']) ? $data['image']->store('public/images') :
            $course['image']);

        $course->name = $data['name'];
        $course->image = $imagePath;
        $course->accessibility = $data['accessibility'];
        $course->description = $data['description'] ?? null;

        $course->save();

        return response()->json($course->toArray());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
