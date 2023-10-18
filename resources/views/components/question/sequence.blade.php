@props(['question'])

<div class="grid gap-2">
    @foreach ($question->options as $option)        
        <div class="flex items-center" key={ option.id }>
            <div class="mr-1 pr-1 font-bold border-r-4">{{ chr(65 + $loop->index) }}</div>
            @isset($option->image)
                <x-common.image :src="Storage::url($option->image)"></x-common.image>
            @endisset
            <div class="ml-1 my-2">{!! clean($option->text) !!}</div>
        </div>
    @endforeach
</div>