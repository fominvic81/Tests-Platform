@props(['label', 'name', 'id', 'value', 'labelClass', 'wrapClass'])

<div @isset($wrapClass)class="{{ $wrapClass }}"@endisset>
    @isset($label)
        <label for="{{ $id ?? $name }}" @isset($labelClass)class="{{ $labelClass }}"@endisset>{{ $label }}</label>
    @endisset
    <input
        {{ $attributes->merge(['class' => 'py-1 border-2 rounded indent-1']) }}
        type="time"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        @isset($value)
            value="{{ $value }}"
        @endisset
    >
</div>