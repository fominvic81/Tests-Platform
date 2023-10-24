<x-layouts.feed>
    <div class="w-full p-4 bg-white shadow rounded-md">
        <h1 class="text-3xl text-center font-bold">Задати домашнє</h1>
        <h1 class="text-xl text-center font-bold">{{ $test->name }}</h1>
        <form action="{{ route('test.exam.store', $test->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div class="grid grid-cols-2 gap-3 h-min">
                    <label class="text-lg font-semibold col-span-2">
                        Назва
                        <input type="text" name="label" value="{{ old('label') ?? $test->name }}" placeholder="Назва" class="w-full bg-gray-50 border-2 rounded p-1">
                    </label>
                    <label class="text-lg font-semibold">
                        Початок
                        <input type="datetime-local" name="begin" value="{{ old('begin') ?? date('Y-m-d H:00') }}" class="w-full bg-gray-50 border-2 rounded p-1">
                    </label>
                    <label class="text-lg font-semibold">
                        Кінець
                        <input type="datetime-local" name="end" value="{{ old('end') ?? date('Y-m-d H:00', strtotime("+1 day")) }}" class="w-full bg-gray-50 border-2 rounded p-1">
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <label class="text-lg font-semibold">
                        Мінімальні бали
                        <input type="number" name="points_min" value="{{ old('points_min') ?? 2 }}" class="bg-gray-50 border-2 rounded p-1">
                    </label>
                    <label class="text-lg font-semibold">
                        Максимальні бали
                        <input type="number" name="points_max" value="{{ old('points_max') ?? 12 }}" class="bg-gray-50 border-2 rounded p-1">
                    </label>
                    <label class="text-lg font-semibold col-span-2">
                        <input type="time" name="time" value="{{ old('time') ?? '00:40' }}" class="bg-gray-50 border-2 rounded p-1">
                        Час на виконання
                    </label>
                    <label class="text-lg font-semibold col-span-2 flex items-center gap-1">
                        <input type="checkbox" name="shuffle_questions" value="1" @checked(old('shuffle_questions') ?? false) class="appearance-none w-5 h-5 bg-gray-50 border rounded checked:bg-sky-400">
                        Перемішати питання
                    </label>
                    <label class="text-lg font-semibold col-span-2 flex items-center gap-1">
                        <input type="checkbox" name="shuffle_options" value="1" @checked(old('shuffle_options') ?? false) class="appearance-none w-5 h-5 bg-gray-50 border rounded checked:bg-sky-400">
                        Перемішати відповіді
                    </label>
                    <label class="text-lg font-semibold col-span-2 flex items-center gap-1">
                        <input type="checkbox" name="show_result" value="1" @checked(old('show_result') ?? true) class="appearance-none w-5 h-5 bg-gray-50 border rounded checked:bg-sky-400">
                        Показати результат
                    </label>
                </div>

                <x-form.errors></x-form.errors>

                <button class="col-span-2 p-2 bg-sky-500 text-lg font-semibold rounded">Задати</button>
            </div>
        </form>
    </div>
</x-layouts.feed>