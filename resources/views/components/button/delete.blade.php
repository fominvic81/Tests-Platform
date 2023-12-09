@props(['href'])

<form action="{{ $href }}" method="POST" x-data x-on:submit="if(!confirm('Точно видалити?')) $event.preventDefault()">
    @method('DELETE')
    @csrf
    <button class="block w-9 h-9 rounded-md border-2 transition-colors hover:bg-red-500" href="{{ $href }}"><x-svg path="common/delete.svg"></x-svg></button>
</form>