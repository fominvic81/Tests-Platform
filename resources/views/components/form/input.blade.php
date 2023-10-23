@props(['label', 'name', 'type', 'value', 'placeholder'])

@isset($label)<label for="{{ $name }}-field" class="text-lg">{{ $label }}</label>@endisset
<input
    class="w-full h-10 bg-gray-50 border-2 rounded text-lg border-gray-300 indent-1"
    type="{{ isset($type) ? $type : 'text' }}"
    id="{{ $name }}-field"
    name="{{ $name }}"
    @isset($placeholder)
        placeholder="{{ $placeholder }}"
    @endisset
    @isset($value)
        value="{{ $value === 'old()' ? old($name) : $value }}"
    @endisset
>