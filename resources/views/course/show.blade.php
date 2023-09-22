<x-layouts.app>
    <div class="w-full md:max-w-5xl mt-5 m-auto">
        <div class="p-5 bg-white shadow-md">
            <h1 class="text-2xl">{{ $course->name }}</h1>
            <a href="" class="text-blue-600 hover:underline hover:text-blue-400">{{ $course->user->fullname }}</a>
        </div>
        <div class="grid grid-cols-2 w-full max-w-5xl mt-3 mx-auto gap-4">
    
            @if (Auth::user()?->id === $course->user->id)
                <a href="{{ route('test.create') }}" class="flex justify-center items-center col-span-2 text-2xl p-5 bg-gray-50 hover:bg-gray-100 border-2 border-gray-200">
                    Створити тест
                </a>
            @endif

            <a href="" class="w-full p-4 flex justify-between bg-white border border-gray-200 hover:bg-gray-50">
                <div>
                    <h1 class="text-xl">ЗНО Українська мова 2021</h1>
                    <div class="text-gray-500">20 Завдань</div>
                </div>
                <div class="flex justify-center items-center h-full aspect-square bg-gray-200 border border-gray-300 rounded text-2xl font-bold">
                    20%
                </div>
            </a>
            <div class="w-full h-28 p-4 bg-white border border-gray-200"></div>
            <div class="w-full h-28 p-4 bg-white border border-gray-200"></div>
            <div class="w-full h-28 p-4 bg-white border border-gray-200"></div>
            <div class="w-full h-28 p-4 bg-white border border-gray-200"></div>
            <div class="w-full h-28 p-4 bg-white border border-gray-200"></div>
            <div class="w-full h-28 p-4 bg-white border border-gray-200"></div>
    
        </div>
    </div>
    {{-- <h1 class="text-2xl">{{ $course->name }}</h1> --}}
</x-layouts.app>