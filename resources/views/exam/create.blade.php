<x-layouts.feed>
    <div class="w-full p-4 bg-white shadow rounded-md text-md font-semibold">
        <h1 class="text-3xl text-center font-bold">Задати домашнє завдання</h1>
        <h1 class="text-xl text-center font-bold">{{ $test->name }}</h1>
        <form action="{{ route('test.exam.store', $test->id) }}" method="POST">
            @csrf
            @include('exam.inc.form')
            <x-form.submit class="mt-2">Задати</x-form.submit>
        </form>
    </div>
</x-layouts.feed>