@props(['name', 'label'])

@isset($label)<label for="{{ $name }}-text">{{ $label }}</label>@endisset
<textarea class="w-full border border-gray-300 resize-y h-40 indent-1" name="{{ $name }}" id="{{ $name }}-text" placeholder="{{ $slot }}"></textarea>