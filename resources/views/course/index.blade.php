<x-layouts.feed :title="$title">
    <h1 class="mx-2 mb-5 text-3xl font-bold text-gray-600">{{ $title }}</h1>
    @if ($courses->count() === 0)
        <h2 class="text-2xl text-center font-semibold">Курсів немає</h2>
    @else
        <div class="grid gap-5">
            @foreach ($courses as $course)
                <x-course.card :course="$course"></x-course.card>
            @endforeach
            {{ $courses->links() }}
        </div>
    @endif
</x-layouts.feed>