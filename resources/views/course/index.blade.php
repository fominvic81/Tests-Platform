<x-layouts.feed>
    @foreach ($courses as $course)
        <div class="bg-white p-3 my-4 shadow">
            <a class="text-lg" href="{{ route('course.show', $course->id) }}">{{ $course->name }}</a>
            <div>
                <span>Автор: </span><a href="" class="text-blue-600 hover:underline hover:text-blue-400">{{ $course->user->fullname }}</a>
            </div>
            <div>{{ $course->description }}</div>
        </div>
    @endforeach
    {{ $courses->links() }}
</x-layouts.feed>