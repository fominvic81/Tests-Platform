<x-layouts.modal title="Приєднатися до тесту">
    <form action="{{ route('exam.start') }}" method="POST" class="text-lg font-semibold">
        @csrf
        <div class="grid gap-2">
            <x-form.input name="code" label="Код доступу" value="{{ old('code') ?? $code }}" placeholder="Код доступу"></x-form.input>
            <x-form.input name="name" label="Прізвище, Ім'я" value="{{ old('name') ?? Auth::user()?->fullname }}" placeholder="Прізвище, Ім'я"></x-form.input>

            <x-form.errors></x-form.errors>

            <x-form.submit>Приєднатися</x-form.submit>
        </div>
    </form>
</x-layouts.modal>