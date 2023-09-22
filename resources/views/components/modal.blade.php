@props(['title'])

<x-layouts.base class="flex items-center flex-col" :title="$title">
    <h1 class="mt-40 text-3xl">{{ $title }}</h1>
    <div class="flex flex-col items-center w-80 bg-gray-100 px-8 py-6 border border-gray-300 mt-5 rounded-lg">
        {{ $slot }}
    </div>
</x-layouts.base>