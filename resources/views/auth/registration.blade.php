<x-layouts.modal title="Реєстрація">
    <form method="POST" action="{{ route('registration') }}">
        @csrf
        <x-form.input name="firstname" label="Ім'я" value="{{ old('firstname') }}" placeholder="Ім'я"></x-form.input>
        <x-form.input name="lastname" label="Прізвище" value="{{ old('lastname') }}" placeholder="Прізвище"></x-form.input>
        <x-form.input name="email" label="Email" value="{{ old('email') }}" placeholder="Email"></x-form.input>

        <x-form.input type="password" name="password" label="Пароль" placeholder="Пароль"></x-form.input>
        <x-form.input type="password" name="password_confirmation" label="Підтвердження паролю" placeholder="Підтвердження паролю"></x-form.input>

        <x-form.errors></x-form.errors>

        <x-form.submit class="mt-2">Зареєструватись</x-form.submit>

        <x-form.anchor href="{{ route('login') }}">Вже є акаунт?</x-form.anchor>
    </form>
</x-layouts.modal>