@props(['name', 'label', 'value'])

@isset($label)<label for="{{ $name }}-text">{{ $label }}</label>@endisset
<textarea
    class="w-full bg-gray-50 border border-gray-300 resize-y h-20 indent-1"
    name="{{ $name }}"
    id="{{ $name }}-text"
    placeholder="{{ $slot }}"
>@isset($value){{ $value === 'old()' ? old($name) : $value }}@endisset</textarea>