<footer {{ $attributes->merge(['class' => 'w-full px-2 bg-sky-800 flex flex-col items-center']) }}>
    <div class="w-full max-w-5xl h-full grid grid-cols-3 py-5">
        <div class="col-span-1">
            <h1 class="text-white text-lg font-bold">Розділи</h1>
            <a class="block w-fit text-white hover:text-blue-200" href="">Тести</a>
            <a class="block w-fit text-white hover:text-blue-200" href="">Курси</a>    
            <a class="block w-fit text-white hover:text-blue-200" href="">ЗНО</a>
            <a class="block w-fit text-white hover:text-blue-200" href="">Бібліотека</a>    
        </div>
        <div class="col-span-1">
            <h1 class="text-white text-lg font-bold">Аккаунт</h1>
            @guest
                <a class="block w-fit text-white hover:text-blue-200" href="{{ route('registration') }}">Реєстрація</a>
                <a class="block w-fit text-white hover:text-blue-200" href="">Реєстрація для учня</a>
                <a class="block w-fit text-white hover:text-blue-200" href="{{ route('login') }}">Вхід</a>    
            @endguest
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-fit text-white hover:text-blue-200">Вийти</button>
                </form>
            @endauth
        </div>
        <div class="col-span-1">
            <h1 class="text-white text-lg font-bold">Про нас</h1>
            <a class="block w-fit text-white hover:text-blue-200" href="">Про проект</a>
        </div>
    </div>
</footer>