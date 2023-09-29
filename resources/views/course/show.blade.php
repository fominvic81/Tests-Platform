<x-layouts.feed>
    <div class="p-5 bg-white shadow-md">
        <h1 class="text-2xl">{{ $course->name }}</h1>
        <span>Автор: </span><a href="" class="text-blue-600 hover:underline hover:text-blue-400">{{ $course->user->fullname }}</a>
        <div>{{ $course->description }}</div>
    </div>
    <div class="grid grid-cols-2 w-full max-w-5xl mt-3 pb-10 mx-auto gap-4">

        @if (Auth::user()?->id === $course->user->id)
            <a href="{{ route('test.create', [ 'course' => $course->id ]) }}" class="flex justify-center items-center col-span-2 text-2xl p-5 bg-gray-50 hover:bg-gray-100 border-2 border-gray-200">
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