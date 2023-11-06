@props(['image', 'name', 'delname'])

<label x-data="{ image: {{ isset($image) ? '\'' . $image . '\'' : 'undefined' }} }" class="w-full h-full border-2 border-dashed relative flex items-center justify-center">
    <img class="max-w-full max-h-full" x-bind:src="image ?? '/images/add-image.png'" alt="Зоображення" />
    <div class="absolute w-full py-1 text-center bottom-0 bg-gray-200 bg-opacity-40 border-t" x-text="image ? 'Видалити' : 'Додати зображення'"></div>
    <input
        type="file"
        name="{{ $name ?? 'image' }}"
        accept="image/*"
        class="hidden"
        x-on:click="if (!image) return; $event.preventDefault(); image = undefined; $event.currentTarget.value = '';"
        x-on:change="image = URL.createObjectURL($event.target.files?.item(0));"
    />
    <input type="hidden" name="{{ $delname ?? "del_image" }}" x-bind:value="!image ? 1 : 0" />
</label>