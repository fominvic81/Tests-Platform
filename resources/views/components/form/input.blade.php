@props(['label', 'name', 'type', 'value'])

@isset($label)<label for="{{ $name }}-field">{{ $label }}</label>@endisset
<input
    class="w-full h-8 bg-gray-50 border border-gray-300 indent-1"
    type="{{ isset($type) ? $type : 'text' }}"
    placeholder="{{ $slot }}"
    id="{{ $name }}-field"
    name="{{ $name }}"
    @isset($value)
        value="{{ $value === 'old()' ? old($name) : $value }}"
    @endisset
>