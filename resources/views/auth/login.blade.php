<x-layouts.modal title="Вхід">
    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <x-form.input type="email" name="email" label="Email" value="{{ old('email') }}" placeholder="Email"></x-form.input>
        <x-form.input type="password" name="password" label="Пароль" placeholder="Пароль"></x-form.input>

        <x-form.errors></x-form.errors>

        <x-form.submit class="mt-2">Увійти</x-form.submit>

        <x-form.anchor href="{{ route('registration.show') }}">Зареєструватися</x-form.anchor>
    </form>
</x-layouts.modal>