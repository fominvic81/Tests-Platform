<x-layouts.feed title="Результати">
    <h1 class="mx-2 mb-3 text-3xl font-bold text-gray-600">Результати</h1>
    <div>

    </div>
    @if ($sessions->count() === 0)
        <h2 class="text-2xl text-center font-semibold">Ви ще не проходили жодного тесту</h2>
    @else
        <div class="grid gap-5">
            @foreach ($sessions as $session)
                <div x-data x-on:click="location.href = '{{ route($session->hasEnded() ? 'testing.result' : 'testing.show', $session) }}'" class="block p-2 bg-white shadow-md rounded-md border-2 hover:brightness-95">
                    @if (!$session->hasEnded())
                        <div class="bg-yellow-300 rounded w-fit px-2 mx-3 flex items-center font-bold">
                            <div class="w-3 h-3 bg-red-600 rounded-full mr-1 animate animate-[pulse_2s_cubic-bezier(0.4,0,0.6,1)_infinite] opacity-0"></div>Активний
                        </div>
                    @endif
                    @if ($session->exam)
                        <div>Задав: {{ $session->exam->user->fullname }}</div>
                    @else 
                        <div>Тест: <a x-on:click.stop class="text-blue-500 hover:text-blue-300 hover:underline" href="{{ route('test.show', $session->test) }}">{{ $session->test->name }}</a></div>
                    @endif
                    <div>Початок: {{ App\Helpers\Timezone::getDatetime($session->created_at, 'Y.m.d H:i') }}</div>
                    @if ($session->hasEnded())
                        <div>
                            Використано часу: {{ preg_replace('/^00:/', '', date('H:i:s', $session->ends_at->timestamp - $session->created_at->timestamp)) }}
                            @if ($session->settings->time)
                                / {{ preg_replace('/^00:/', '', $session->settings->time) }}
                            @endif
                        </div>
                    @endif
                    @if ($session->hasEnded() && $session->settings->show_result)
                        <div class="font-bold">Оцінка: {{ round($session->stats()['points']) }} / {{ $session->settings->points_max }}</div>
                        <x-result.pointsbar :stats="$session->stats()"></x-result.pointsbar>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.feed>