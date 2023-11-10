<header {{ $attributes->merge(['class' => 'h-10 bg-white lg:px-40 shadow flex justify-between items-center select-none']) }}>
    <div class="flex h-full">
        <a class="flex items-center" href="{{ route('home')}} ">
            <img class="h-full" src="{{ URL::to('/images/hero.png') }}" alt="Hero" title="Головна сторінка">
        </a>
        <div class="hidden md:flex h-full ml-2">
            <a class="h-full flex items-center px-4 hover:bg-gray-100" href="{{ route('home') }}">Головна</a>
            <a class="h-full flex items-center px-4 hover:bg-gray-100" href="{{ route('test.index') }}">Тести</a>
            <a class="h-full flex items-center px-4 hover:bg-gray-100" href="{{ route('course.index') }}">Курси</a>
            <a class="h-full flex items-center px-4 hover:bg-gray-100" href="">ЗНО</a>
        </div>
    </div>
    <div class="flex h-full">
        @auth
            <div class="relative" x-data="{ open: false }" x-on:click.outside="open = false">
                <button x-on:click="open = !open" class="flex h-full hover:bg-gray-100">
                    <span class="h-full flex items-center mx-2 whitespace-nowrap">{{ Auth::user()->fullname }}</span>
                    <div class="w-10 h-10">
                        <img class="w-full h-full" src="{{ URL::to('/images/profile.png') }}" alt="Profile">
                    </div>
                </button>
                <div x-cloak x-show="open" class="absolute grid w-max right-0 bg-white rounded-b-md border border-t-0 border-gray-300 overflow-clip z-50">
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="">Профіль</a>
                    <hr class="my-1">
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="{{ route('test.my') }}">Мої тести</a>
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="{{ route('test.saved') }}">Збережені тести</a>
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="{{ route('test.create') }}">Створити тест</a>
                    <hr class="my-1">
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="{{ route('course.my') }}">Мої курси</a>
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="{{ route('course.saved') }}">Збережені курси</a>
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="{{ route('course.create') }}">Створити курс</a>
                    <hr class="my-1">
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="{{ route('exam.index') }}">Домашні завдання</a>
                    <hr class="my-1">
                    <a class="hover:bg-gray-100 px-6 py-[2px]" href="">Налаштування</a>
                    <form action="{{ route('logout') }}" method="POST" class="hover:bg-gray-100 px-6 py-[2px]">
                        @csrf
                        <button type="submit" class="w-full text-start">Вийти</button>
                    </form>
                </div>
            </div>
        @endauth
        @guest
            <a class="h-full flex items-center px-4" href="{{ route('login') }}">Вхід</a>
            <a class="h-full flex items-center px-4" href="{{ route('registration') }}">Реєстрація</a>
        @endguest
    </div>
</header>