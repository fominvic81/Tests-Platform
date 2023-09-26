<header {{ $attributes->merge(['class' => 'w-full px-2 h-10 bg-white border-b flex justify-center overflow-clip']) }}>
    <div class="w-full h-full flex flex-row justify-between items-center">

        <div class="flex h-full">
            <a class="flex items-center px-2" href="{{ route('home')}} ">
                <img class="h-full" src="{{ URL::to('/images/hero.png') }}" alt="Hero" title="Головна сторінка">
            </a>
            <div class="md:flex hidden h-full">
                <a class="h-full flex items-center px-4" href="{{ route('home') }}">Головна</a>
                <a class="h-full flex items-center px-4" href="{{ route('course.index') }}">Курси</a>
                <a class="h-full flex items-center px-4" href="{{ route('test.index') }}">Тести</a>
                <a class="h-full flex items-center px-4" href="">ЗНО</a>
            </div>
        </div>
        <div class="flex h-full">
            @auth
                <div class="flex h-full">
                    <span class="h-full flex items-center mx-2 whitespace-nowrap">{{ Auth::user()->fullname }}</span>
                    <img class="h-full" src="{{ URL::to('/images/profile.png') }}" alt="Profile">
                </div>
            @else
                <a class="h-full flex items-center px-4" href="{{ route('login') }}">Вхід</a>
                <a class="h-full flex items-center px-4" href="{{ route('registration') }}">Реєстрація</a>
            @endauth
        </div>
    </div>
</header>