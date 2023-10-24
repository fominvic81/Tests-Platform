@props(['title'])

<x-layouts.base class="flex items-center flex-col bg-gray-100" :title="$title">
    <h1 class="mt-40 text-3xl">{{ $title }}</h1>
    <div class="flex flex-col items-center w-80 bg-white shadow-md p-6 mt-5 rounded-lg">
        {{ $slot }}
    </div>
</x-layouts.base>