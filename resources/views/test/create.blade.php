<x-layouts.app>

    <div class="w-[600px] max-w-full mt-20 m-auto p-12 bg-white border shadow">
        <form class="w-full h-full" action="{{ route('test.store') }}" method="POST">
            @csrf
            <h1 class="m-auto text-2xl w-min whitespace-nowrap">Створити тест</h1>
            <x-form.input name="name" label="Назва Тесту">Назва</x-form.input>
            <x-form.select name="course" label="Виберіть курс">
                <option class="font-bold" value="0">Без курсу</option>
                @foreach (Auth::user()->courses as $course)
                    <option value="{{ $course->id }}" @selected(Request::query('course') === strval($course->id))>{{ $course->name }}</option>
                @endforeach
            </x-form.select>
            <x-form.text name="description" label="Опис">Опис</x-form.text>
            <x-form.errors></x-form.errors>
            <x-form.submit>Створити</x-form.submit>
        </form>
    </div>

</x-layouts.app>