<x-layouts.feed title="Домашні завдання" class="grid gap-4">
    <h1 class="text-3xl font-bold text-gray-600">Домашні завдання</h1>
    
    @if ($exams->count() === 0)
        <h2 class="text-2xl text-center font-semibold">Ви ще не задали жодного доманього завдання</h2>
    @else
        @foreach ($exams as $exam)
            <div class="grid grid-cols-[1fr_auto_auto] gap-3 items-center bg-white p-3 shadow-md rounded-md">
                <div>
                    <a class="text-lg font-semibold" href="{{ route('exam.show', $exam->id) }}">{{ $exam->label }}</a>
                    <div>Початок: {{ App\Helpers\Timezone::getDatetime($exam->begin_at, 'H:i m.d') }}</div>
                    <div>Кінець: {{ App\Helpers\Timezone::getDatetime($exam->end_at, 'H:i m.d') }}</div>
                </div>
                <div class="flex items-center justify-center h-12 px-4 rounded text-xl font-bold bg-gray-300">
                    {{ $exam->sessions()->count() }} Учасників
                </div>
            </div>
        @endforeach
    @endif

</x-layouts.feed>