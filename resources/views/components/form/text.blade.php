@props(['name', 'label', 'value', 'placeholder'])

@isset($label)<label for="{{ $name }}-text">{{ $label }}</label>@endisset
<textarea
    class="w-full bg-gray-50 border border-gray-300 resize-y h-20 indent-1"
    name="{{ $name }}"
    id="{{ $name }}-text"
    @isset($placeholder)
        placeholder="{{ $placeholder }}"
    @endisset
>@isset($value){{ $value === 'old()' ? old($name) : $value }}@endisset</textarea>