@props(['question'])

<div>
    @foreach ($question->data['options'] as $option)
        <div class="flex items-center">
            <div class="w-5 h-5 rounded mr-1 bg-gray-300"></div>
            @isset($option['image'])
                <x-common.image :src="App\Helpers\ImageHelper::url($option['image'])"></x-common.image>
            @endisset
            <div class='ml-1 my-2'>{!! clean($option['text']) !!}</div>
        </div>
    @endforeach
</div>