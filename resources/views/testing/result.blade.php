
@php
    $stats = $session->stats();
    $percentCorrect = round($stats['correct'] / $stats['max'] * 100);
    $percentWrong = round($stats['wrong'] / $stats['max'] * 100);
@endphp

<x-layouts.base class="bg-gray-100" title="Результат тестування">
    <div class="w-full h-14 bg-emerald-400 shadow-md"></div>

    <div class="w-full max-w-3xl mx-auto ">
        <div class="mt-5 p-3 bg-white rounded-md shadow-md">
            <div class="text-xl font-semibold">
                {{ $session->test->name }}
            </div>
            <hr class="my-3">
            <div class="w-max mx-auto text-lg font-semibold">Задав(ла): {{ $session->exam->user->fullname }}</div>
            <div class="w-max mx-auto text-lg font-semibold">Виконав(ла): {{ $session->student_name }}</div>
            <div class="w-max mx-auto text-lg font-semibold">Почато: {{ preg_replace('/^00:/', '', $session->created_at->format('Y:m:d H:i')) }}</div>
            <div class="w-max mx-auto text-lg font-semibold">Витрачено часу: {{ preg_replace('/^00:/', '', date('H:i:s', $session->ends_at->timestamp - $session->created_at->timestamp)) }}</div>
            @if ($session->settings->show_result)
                <hr class="my-3">
                <div class="mx-20 grid grid-cols-[auto_1fr] md:grid-cols-[repeat(2,auto_1fr)] items-center gap-3 my-2 text-xl whitespace-nowrap">
                    <div>Оцінка:</div>
                    <div class="bg-gray-200 max-w-sm ml-2 p-2 grow text-center rounded font-bold">{{ round($stats['points']) }} / {{ $session->settings->points_max }}</div>
                    <div>Тестові Бали:</div>
                    <div class="bg-gray-200 max-w-sm ml-2 p-2 grow text-center rounded font-bold">{{ round($stats['correct']) }} / {{ $stats['max'] }}</div>
                </div>
                <div class="h-8 mx-10 bg-gray-200 rounded overflow-hidden flex font-bold text-gray-200">
                    <div class="h-full flex items-center justify-center bg-green-500 border-r" style="width: {{ $percentCorrect }}%">{{ $percentCorrect > 2 ? "$percentCorrect%" : null }}</div>
                    <div class="h-full flex items-center justify-center bg-red-600" style="width: {{ $percentWrong }}%">{{ $percentWrong > 2 ? "$percentWrong%" : null }}</div>
                </div>
            @endif
        </div>
    </div>

    @if ($session->settings->show_result)
        @foreach ($session->test->questions as $question)
            {{-- TODO --}}
        @endforeach
    @endif

</x-layouts.base>