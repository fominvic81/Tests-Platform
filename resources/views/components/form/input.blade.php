@props(['label', 'name', 'type'])

@isset($label)<label for="{{ $name }}-field">{{ $label }}</label>@endisset
<input
    class="w-full h-8 border border-gray-300 indent-1"
    type="{{ isset($type) ? $type : 'text' }}"
    placeholder="{{ $slot }}"
    value="{{ !isset($type) || $type !== 'password' ? old($name) : '' }}"
    id="{{ $name }}-field"
    name="{{ $name }}"
>