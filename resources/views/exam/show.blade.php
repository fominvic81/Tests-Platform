<x-layouts.feed :title="$exam->label">
    <h1 class="text-3xl font-bold text-center">Домашнє завдання</h1>
    <div class="p-3 text-lg shadow rounded-md mt-5 bg-white">
        <h1 class="text-2xl font-bold text-center">{{ $exam->label }}</h1>
        <div class="grid grid-cols-[1fr_auto]">
            <div>
                <div>Початок: {{ App\Helpers\Timezone::getDatetime($exam->begin_at, 'H:i m.d') }}</div><div>Кінець: {{ App\Helpers\Timezone::getDatetime($exam->end_at, 'H:i m.d') }}</div>
                <div>Час на виконання: {{ date('H:i', strtotime($exam->settings->time)) }}</div>
                <div>
                    Тест: <a href="{{ route('test.show', $exam->test->id) }}" class="text-blue-600 hover:text-blue-400">{{ $exam->test->name }}</a>
                </div>
            </div>
            <a href="{{ route('exam.edit', $exam->id) }}" class="block w-10 h-10 rounded-md border-2 hover:bg-gray-200">
                <x-svg path="common/edit.svg"></x-svg>
            </a>
        </div>
    </div>
    <div class="p-3 text-lg shadow rounded-md mt-5 bg-emerald-200  grid grid-cols-[1fr_150px]">
        <h1 class="text-2xl font-bold text-center col-span-2">Щоб пройти тест</h1>
        <div>
            <div>
                Введіть код: <span class="text-2xl font-semibold text-emerald-600">{{ $exam->code }}</span> за посиланням <span class="text-2xl font-semibold text-emerald-600">{{ route('exam.join') }}</span>
            </div>
            <div class="mt-3">
                Або перейдіть за посиланням: <a class="text-2xl font-semibold text-blue-600 hover:text-blue-400" target="_block" href="{{ route('exam.join', [ 'code' => $exam->code ]) }}">{{ route('exam.join', [ 'code' => $exam->code ]) }}</a>
            </div>
        </div>
        {{-- <div class="w-full aspect-square bg-gray-100"></div> --}}
    </div>
    <div class="p-3 text-lg shadow rounded-md mt-5 bg-white grid gap-2">
        <div>Виконані завдання:</div>
        @foreach ($exam->sessions as $session)
            <div class="bg-emerald-400 p-1 rounded">
                {{ $session->student_name }}
                {{ json_encode($session->stats()) }}
            </div>
        @endforeach
    </div>
</x-layouts.feed>