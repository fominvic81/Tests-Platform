<x-layouts.feed title="Налаштування">
    <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid sm:grid-cols-[auto_1fr] gap-3 p-3 bg-white rounded-md shadow font-semibold">
            <div class="aspect-square w-32">
                <x-form.image :image="App\Helpers\ImageHelper::url($user->image)"></x-form.image>
            </div>
            <div>
                <x-form.input name="firstname" :value="$user->firstname" label="Ім'я" placeholder="Ім'я"></x-form.input>
                <x-form.input name="lastname" :value="$user->lastname" label="Прізвище" placeholder="Прізвище"></x-form.input>
            </div>
            <div class="col-span-full">
                <x-form.textarea name="about" :value="$user->about" label="Про себе" placeholder="Я..."></x-form.textarea>
                <x-form.errors></x-form.errors>
                <x-form.submit>Зберегти</x-form.submit>
            </div>
        </div>
    </form>
</x-layouts.feed>