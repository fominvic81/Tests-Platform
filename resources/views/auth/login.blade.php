<x-modal title="Вхід">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-form.input name="email" label="Email" value="old()" placeholder="Email"></x-form.input>
        <x-form.input type="password" name="password" label="Пароль" value="old()" placeholder="Пароль"></x-form.input>

        <x-form.errors></x-form.errors>

        <x-form.submit>Увійти</x-form.submit>

        <x-form.anchor href="{{ route('registration') }}">Зареєструватися</x-form.anchor>
    </form>
</x-modal>