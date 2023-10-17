@props(['question'])

<div>
    @foreach ($question->options as $option)
        <div class="flex items-center">
            <div class="w-5 h-5 rounded mr-1 bg-gray-300"></div>
            @isset($option->image)
                <x-question.image :src="Storage::url($option->image)"></x-question.image>
            @endisset
            <div class='ml-1 my-2'>{!! clean($option->text) !!}</div>
        </div>
    @endforeach
</div>