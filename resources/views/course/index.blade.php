<x-layouts.feed>
    @foreach ($courses as $course)
        <a class="block" href="{{ route('course.show', $course->id) }}">{{ $course->name }}</a>
    @endforeach
    {{ $courses->links() }}
</x-layouts.feed>