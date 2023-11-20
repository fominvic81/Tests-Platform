<x-layouts.feed title="Головна">
    {{-- <img src="{{ URL::to('/images/profile.png') }}" alt=""> --}}
    {{-- <div class=""></div> --}}

    <div class="grid gap-3 text-lh font-bold">
        <div class="grid grid-cols-[1fr_auto] border-2 rounded-md hover:scale-[99%] transition-all overflow-clip">
            <a href="{{ route('test.index') }}" class="p-3 bg-white transition-all hover:brightness-95">{{ DB::table('tests')->count() }} Тестів</a>
            <a href="{{ route('test.create') }}" class="py-3 px-6 bg-yellow-300 transition-all hover:brightness-95">Створити</a>
        </div>
        <div class="grid grid-cols-[1fr_auto] border-2 rounded-md hover:scale-[99%] transition-all overflow-clip">
            <a href="{{ route('test.index') }}" class="p-3 bg-white transition-all hover:brightness-95">{{ DB::table('courses')->count() }} Курсів</a>
            <a href="{{ route('test.create') }}" class="py-3 px-6 bg-yellow-300 transition-all hover:brightness-95">Створити</a>
        </div>
    </div>

    <div class="grid grid-cols-3 p-12 mx-auto gap-4">
        
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>
        <div class="w-full h-28 p-4 bg-white border border-gray-200 rounded-md"></div>

    </div>
    {{-- <div class="h-screen bg-gray-100 border-t-2 border-gray-200">

    </div> --}}
</x-layouts.feed>