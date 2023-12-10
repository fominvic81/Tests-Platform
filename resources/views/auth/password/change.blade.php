<x-layouts.modal title="Зміна пароля">
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <x-form.input type="password" name="old_password" label="Старий пароль" placeholder="Старий пароль" :value="old('old_password')"></x-form.input>
        <x-form.input type="password" name="new_password" label="Новий пароль" placeholder="Новий пароль" :value="old('new_password')"></x-form.input>
        <x-form.input type="password" name="new_password_confirmation" label="Підтвердження пароля" placeholder="Підтвердження пароля" :value="old('new_password_confirmation')"></x-form.input>

        <x-form.errors></x-form.errors>

        <x-form.submit class="mt-2">Змінити</x-form.submit>
    </form>
</x-layouts.modal>