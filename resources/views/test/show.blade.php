<x-layouts.feed>
    <div class="flex justify-between items-start p-5 bg-white shadow-md">
        <div>
            <h1 class="text-2xl">{{ $test->name }}</h1>
            <div>
                @if($test->subject_id > 1)
                    {{ $test->subject->name }}
                @endif
                @if($test->grade_id > 1)
                    {{ $test->grade->name }}
                @endif
            </div>
            <span>Автор: </span><a href="" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->user->fullname }}</a>
            <br>
            @isset($test->course)
                <span>Курс: </span><a href="{{ route('course.show', $test->course->id) }}" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->course->name }}</a>
            @endisset
            <div>{{ $test->description }}</div>
        </div>
        @if (Auth::user()->id === $test->user_id)
            <a class="p-2 rounded-md bg-gray-100 border border-gray-300" href="{{ route('test.edit', $test->id) }}">Редагувати</a>
        @endif
    </div>
    <div class="grid grid-cols-2 w-full max-w-5xl mt-3 mx-auto gap-4">
    </div>
</x-layouts.feed>