<x-layouts.modal :title="$student ? 'Реєстрація для учня' : 'Реєстрація для вчителя'">
    <form method="POST" action="{{ $student ? route('student.registration.store') : route('registration.store') }}">
        @csrf
        <x-form.input name="firstname" label="Ім'я" :value="old('firstname')" placeholder="Ім'я"></x-form.input>
        <x-form.input name="lastname" label="Прізвище" :value="old('lastname')" placeholder="Прізвище"></x-form.input>
        <x-form.input name="email" label="Email" :value="old('email')" placeholder="Email"></x-form.input>

        <x-form.input type="password" name="password" label="Пароль" placeholder="Пароль" :value="old('password')"></x-form.input>
        <x-form.input type="password" name="password_confirmation" label="Підтвердження пароля" placeholder="Підтвердження пароля" :value="old('password_confirmation')"></x-form.input>

        <x-form.errors></x-form.errors>

        <x-form.submit class="mt-2">Зареєструватись</x-form.submit>

        <x-form.anchor href="{{ route('login.show') }}">Вже є акаунт?</x-form.anchor>
        @if ($student)
            <x-form.anchor href="{{ route('registration.show') }}">Я вчитель</x-form.anchor>
        @else
            <x-form.anchor href="{{ route('student.registration.show') }}">Я учень</x-form.anchor>
        @endif
    </form>
</x-layouts.modal>