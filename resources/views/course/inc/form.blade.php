<div class="grid grid-cols-[1fr_auto] gap-3 text-lg">
    <div>
        <x-form.input name="name" :value="old('name') ?? $course->name ?? ''" label="Назва" placeholder="Назва"></x-form.input>
        <x-form.textarea name="description" :value="old('description') ?? $course->description ?? ''" label="Опис" placeholder="Опис"></x-form.textarea>
    </div>
    <div class="w-40 h-40 text-base font-normal">
        <x-form.image :image="isset($course->image) ? App\Helpers\ImageHelper::url($course->image) : null"></x-form.image>
    </div>
    <x-form.select name="accessibility" wrap-class="col-span-full">
        @foreach (App\Enums\Accessibility::cases() as $accessibility)
            <option value="{{ $accessibility->value }}" @selected($accessibility->value == (old('accessibility') ?? $course->accessibility ?? App\Enums\Accessibility::Public->value))>
                @lang('accessibility.'.$accessibility->value)
            </option>
        @endforeach
    </x-form.select>
    <x-form.errors></x-form.errors>
</div>