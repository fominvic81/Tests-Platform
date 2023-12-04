@props(['course'])

<div class="bg-emerald-100 odd:bg-yellow-50 p-3 shadow-md rounded-md grid grid-cols-[auto_1fr_auto] gap-3">
    <x-common.image :src="isset($course->image) ? App\Helpers\ImageHelper::url($course->image) : URL::to('/images/img-placeholder.png')"></x-common.image>
    <div>
        <a class="text-lg font-semibold" href="{{ route('course.show', $course->id) }}">{{ $course->name }}</a>
        <div>
            <a href="{{ route('user.show', $course->user->id) }}" class="text-blue-600 hover:underline hover:text-blue-400 text-lg font-semibold">{{ $course->user->fullname }}</a>
        </div>
        <div class="hidden sm:block">{!! $course->description !!}</div>
    </div>
    <div class="m-1">
        @auth
            <x-button.save
                :saved="Auth::user()->savedCourses()->where('course_id', $course->id)->exists()"
                :url="route('course.save', $course->id)"
            ></x-button.save>
        @endauth
    </div>
</div>