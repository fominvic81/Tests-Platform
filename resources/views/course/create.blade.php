<x-layouts.app>

    <div class="w-[600px] max-w-full mt-20 m-auto p-12 bg-white border border-grat-200 shadow">
        <h1 class="m-auto text-2xl w-min whitespace-nowrap">Створити курс</h1>
        <form class="w-full h-full" action="{{ route('course.store') }}" method="POST">
            @csrf
            <x-form.input name="name" label="Назва курсу" value="old()">Назва</x-form.input>
            <x-form.text name="description" label="Опис" value="old()">Опис</x-form.text>
            <x-form.errors></x-form.errors>
            <x-form.submit>Створити</x-form.submit>
        </form>
    </div>

</x-layouts.app>