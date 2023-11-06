@props(['label', 'name', 'id', 'value', 'placeholder', 'wrapClass', 'labelClass' ])

<div @isset($wrapClass)class="{{ $wrapClass }}"@endisset>
    @isset($label)
        <label for="{{ $id ?? $name }}" @isset($labelClass)class="{{ $labelClass }}"@endisset>{{ $label }}</label>
    @endisset
    <textarea
        {{ $attributes->merge(['class' => 'w-full h-15 border-2 rounded indent-1']) }}
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        @isset($placeholder)
            placeholder="{{ $placeholder }}"
        @endisset
    >{{ $value }}</textarea>
</div>