<x-layouts.feed :title="$course->name">
    <div class="grid grid-cols-[auto_1fr_auto] p-5 bg-white shadow-md rounded-lg">
        <div>
            @isset($course->image)
                <x-common.image :src="App\Helpers\ImageHelper::url($course->image)"></x-common.image>
            @endisset
        </div>
        <div>
            <h1 class="text-2xl">{{ $course->name }}</h1>
            <span>Автор: </span><a href="{{ route('user.show', $course->user->id) }}" class="text-blue-600 hover:underline hover:text-blue-400">{{ $course->user->fullname }}</a>
            <br>
            @isset($course->course)
                <span>Курс: </span><a href="{{ route('course.show', $course->course->id) }}" class="text-blue-600 hover:underline hover:text-blue-400">{{ $course->course->name }}</a>
            @endisset
        </div>
        <div class="grid grid-flow-col gap-1">
            @auth
                @if (Auth::user()->id === $course->user_id)
                    <a
                        class="block w-9 h-9 rounded-md border-2 hover:bg-gray-200"
                        href="{{ route('course.edit', $course->id) }}"
                    ><x-svg path="common/edit.svg"></x-svg></a>
                @endif
                <x-button.save
                    :saved="Auth::user()->savedCourses()->where('course_id', $course->id)->exists()"
                    :url="route('course.save', $course->id)"
                ></x-button.save>
            @endauth
        </div>
        <div class="col-span-3">{!! $course->description !!}</div>
    </div>
    <div class="grid grid-cols-2 w-full max-w-5xl mt-3 pb-10 mx-auto gap-4">

        @if (Auth::user()?->id === $course->user->id)
            <a href="{{ route('test.create', ['course' => $course->id]) }}" class="text-center col-span-2 text-2xl p-5 border-2 rounded-md shadow-md bg-white hover:bg-gray-100">
                Створити тест
            </a>
        @endif

        @foreach ($course->tests as $test)
            <a href="{{ route('test.show', $test->id) }}" class="w-full p-4 flex justify-between bg-white border border-gray-200 hover:bg-gray-50 shadow">
                <div>
                    <h1 class="text-xl">{{ $test->name }}</h1>
                    <div class="text-gray-500">{{ count($test->questions) }} Завдань</div>
                </div>
                <div class="flex justify-center items-center h-full aspect-square bg-gray-200 border border-gray-300 rounded text-2xl font-bold">
                    20%
                </div>
            </a>
        @endforeach

    </div>
</x-layouts.feed>