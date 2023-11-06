@props(['label', 'name', 'id', 'value', 'labelClass', 'wrapClass'])

<div class="flex items-center gap-1 {{ $wrapClass ?? null }}">
    <input type="hidden" name="{{ $name }}" value="0">
    <input
        {{ $attributes->merge(['class' => 'appearance-none w-6 h-6 border-2 rounded-md checked:bg-sky-400']) }}
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        value="1"
        @checked($value ?? false)
    >
    @isset($label)
        <label for="{{ $id ?? $name }}" @isset($labelClass)class="{{ $labelClass }}"@endisset>{{ $label }}</label>
    @endisset
</div>