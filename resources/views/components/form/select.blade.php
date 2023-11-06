@props([ 'name', 'id', 'label', 'wrapClass', 'labelClass' ])

<div @isset($wrapClass)class="{{ $wrapClass }}"@endisset>
    @isset($label)
        <label for="{{ $id ?? $name }}" @isset($labelClass)class="{{ $labelClass }}"@endisset>{{ $label }}</label>
    @endisset
    <select
        {{ $attributes->merge(['class' => 'w-full p-1 border-2 rounded']) }}
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
    >{{ $slot }}</select>
</div>