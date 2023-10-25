<x-layouts.modal title="Приєднатися до тесту">
    <form action="{{ route('exam.start') }}" method="POST" class="text-lg font-semibold">
        @csrf
        <div class="grid gap-2">
            <label>
                Код доступу
                <input type="text" name="code" value="{{ $code ?? old('code') }}" placeholder="Код доступу" class="w-full bg-gray-50 border-2 rounded p-1">
            </label>
            <label>
                Прізвище, Ім'я
                <input type="text" name="name" value="{{ Auth::user()?->fullname ?? old('name') }}" placeholder="Прізвище, Ім'я" class="w-full bg-gray-50 border-2 rounded p-1">
            </label>

            <x-form.errors></x-form.errors>

            <button type="submit" class="bg-sky-500 p-2 rounded">Приєднатися</button>
        </div>
    </form>
</x-layouts.modal>