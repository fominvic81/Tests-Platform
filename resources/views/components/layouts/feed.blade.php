@props(['title'])

<x-layouts.app :title="$title">
    <div {{ $attributes->merge(['class' => 'w-full md:max-w-5xl my-5 m-auto']) }}>
        {{ $slot }}
    </div>
</x-layouts.app>