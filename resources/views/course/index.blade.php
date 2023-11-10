<x-layouts.feed :title="$title">
    <h1 class="mx-2 mb-5 text-3xl font-bold text-gray-600">{{ $title }}</h1>
    <div class="grid gap-5">
        @foreach ($courses as $course)
            <x-course.card :course="$course"></x-course.card>
        @endforeach
        {{ $courses->links() }}
    </div>
</x-layouts.feed>