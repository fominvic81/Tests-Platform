<x-modal title="Реєстрація">
    <form method="POST" action="{{ route('registration') }}">
        @csrf
        <x-form.input name="firstname" label="Ім'я" value="old()">Ім'я</x-form.input>
        <x-form.input name="lastname" label="Прізвище" value="old()">Прізвище</x-form.input>
        <x-form.input name="email" label="Email" value="old()">Email</x-form.input>

        <x-form.input type="password" name="password" label="Пароль">Пароль</x-form.input>
        <x-form.input type="password" name="password_confirmation" label="Підтвердження паролю">Підтвердження паролю</x-form.input>

        <x-form.errors></x-form.errors>

        <x-form.submit>Зареєструватись</x-form.submit>

        <x-form.anchor href="{{ route('login') }}">Вже є акаунт?</x-form.anchor>
    </form>
</x-modal>