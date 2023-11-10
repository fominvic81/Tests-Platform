@props(['saved', 'url'])

<button
    x-data="{ saved: {{ $saved ? 'true' : 'false' }}, saving: false }"
    x-bind:class="saved ? 'stroke-red-400 fill-red-400 bg-red-100' : ''"
    x-on:click="saving = true; axios.post('{{ $url }}', { value: !saved }).then(() => {saved = !saved; saving = false})"
    x-bind:disabled="saving"
    title="Зберегти"
    class="w-9 h-9 p-[5px] border-2 rounded hover:bg-gray-100 transition-colors disabled:bg-gray-300"
><x-svg path="common/add.svg"></x-svg></button>