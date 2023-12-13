<x-layouts.app title="ЗНО">
    <div class="w-full max-w-3xl mx-auto mt-5 p-4 bg-white">
        <h1 class="text-center text-xl font-bold">Тести ЗНО минулих років</h1>

        <div class="grid gap-1 text-gray-700 font-bold mt-5">
            <a class="text-center bg-lime-400 p-2 rounded-md hover:brightness-90" href="{{ route('course.show', 1)}}">Українська мова і література</a>
            <a class="text-center bg-lime-400 p-2 rounded-md hover:brightness-90" href="{{ route('course.show', 2)}}">Математика</a>
            <a class="text-center bg-lime-400 p-2 rounded-md hover:brightness-90" href="{{ route('course.show', 3)}}">Історія України</a>
            <a class="text-center bg-lime-400 p-2 rounded-md hover:brightness-90" href="{{ route('course.show', 4)}}">Англійська мова</a>
            <a class="text-center bg-lime-400 p-2 rounded-md hover:brightness-90" href="{{ route('course.show', 5)}}">Біологія</a>
        </div>
    </div>
</x-layouts.app>
