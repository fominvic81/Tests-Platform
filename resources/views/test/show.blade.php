<x-layouts.feed>
    <div class="p-5 bg-white shadow-md">
        <h1 class="text-2xl">{{ $test->name }}</h1>
        @isset($test->subject)
            {{ $test->subject->name }}
        @endisset
        @isset($test->grade)
            {{ $test->grade->name }}
        @endisset
        <br>
        <span>Автор: </span><a href="" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->user->fullname }}</a>
        <br>
        @isset($test->course)
            <span>Курс: </span><a href="{{ route('course.show', $test->course->id) }}" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->course->name }}</a>
        @endisset

    </div>
    <div class="grid grid-cols-2 w-full max-w-5xl mt-3 mx-auto gap-4">
    </div>
</x-layouts.feed>