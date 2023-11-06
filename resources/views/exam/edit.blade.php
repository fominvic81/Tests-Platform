<x-layouts.feed>
    <div class="w-full p-4 bg-white shadow rounded-md text-md font-semibold">
        <h1 class="text-3xl text-center font-bold">Редагувати домашнє завдання</h1>
        <h1 class="text-xl text-center font-bold">{{ $test->name }}</h1>
        <form action="{{ route('exam.update', $exam->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('exam.inc.form')
            <x-form.submit class="mt-2">Зберегти</x-form.submit>
        </form>
    </div>
</x-layouts.feed>