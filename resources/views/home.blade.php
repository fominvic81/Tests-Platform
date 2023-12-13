<x-layouts.app title="Головна">
    <div class="grid sm:grid-cols-2 items-center gap-3 m-auto max-w-3xl my-5">
        <img class="m-auto w-full" src="{{ URL::to('/images/teacher.png') }}">
        <div class="col-start-1 row-start-1 sm:col-start-2 grid gap-3 h-min items-start bg-blue-200 p-5 rounded-lg shadow-md text-xl">
            <h1 class="font-bold">Інструменти вчителя</h1>
            <a class="block w-full p-2 bg-sky-100 rounded shadow-md transition-all hover:brightness-95" href="{{ route('test.index') }}">Бібліотека тестів</a>
            <a class="block w-full p-2 bg-sky-100 rounded shadow-md transition-all hover:brightness-95" href="{{ route('test.create') }}">Редактор тестів</a>
            <a class="block w-full p-2 bg-sky-100 rounded shadow-md transition-all hover:brightness-95" href="{{ route('exam.index') }}">Результати учнів</a>
        </div>
    </div>
    <div class="grid sm:grid-cols-2 items-center gap-3 m-auto max-w-3xl my-5">
        <div class="grid gap-3 h-min items-start bg-orange-200 p-5 rounded-lg shadow-md text-xl">
            <h1 class="font-bold">Тести ЗНО</h1>
            <a class="block w-full p-2 bg-yellow-100 rounded shadow-md transition-all hover:brightness-95" href="">Українська мова і література</a>
            <a class="block w-full p-2 bg-yellow-100 rounded shadow-md transition-all hover:brightness-95" href="">Математика</a>
            <a class="block w-full p-2 bg-yellow-100 rounded shadow-md transition-all hover:brightness-95" href="">Історія України</a>
            <a class="block w-full p-2 bg-yellow-100 rounded shadow-md transition-all hover:brightness-95" href="">Англійська мова</a>
            {{-- <a class="block w-full p-2 bg-yellow-100 rounded shadow-md transition-all hover:brightness-95" href="">Інше</a> --}}
        </div>
        <img class="m-auto w-full" src="{{ URL::to('/images/student.png') }}">
    </div>
</x-layouts.app>