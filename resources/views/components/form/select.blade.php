@props([ 'name', 'label' ])

@isset($label)<label for="{{ $name }}-select">{{ $label }}</label>@endisset
<select
    class="block w-full p-1 border border-gray-300"
    name="{{ $name }}"
    id="{{ $name }}-select">
    {{ $slot }}
</select>