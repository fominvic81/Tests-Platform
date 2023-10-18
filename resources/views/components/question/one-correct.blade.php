@props(['question'])

<div>
    @foreach ($question->options as $option)
        <div class="flex items-center">
            <div class="w-5 h-5 rounded-full mr-1 bg-gray-300"></div>
            @isset($option->image)
                <x-common.image :src="Storage::url($option->image)"></x-common.image>
            @endisset
            <div class='ml-1 my-2'>{!! clean($option->text) !!}</div>
        </div>
    @endforeach
</div>