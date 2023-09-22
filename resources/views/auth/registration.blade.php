<x-modal title="Реєстрація">
    <form method="POST" action="{{ route('registration') }}">
        @csrf
        <x-form.input name="firstname" label="Ім'я">Ім'я</x-form.input>
        <x-form.input name="lastname" label="Прізвище">Прізвище</x-form.input>
        <x-form.input name="email" label="Email">Email</x-form.input>

        <x-form.input type="password" name="password" label="Пароль">Пароль</x-form.input>
        <x-form.input type="password" name="password_confirmation" label="Підтвердження паролю">Підтвердження паролю</x-form.input>

        <x-form.errors></x-form.errors>

        <x-form.submit>Зареєструватись</x-form.submit>

        <x-form.anchor href="{{ route('login') }}">Вже є акаунт?</x-form.anchor>
    </form>
</x-modal>