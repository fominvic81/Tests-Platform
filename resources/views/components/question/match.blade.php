@props(['question'])

<div class="grid grid-cols-2">
    @php
        $options = $question->options->filter(fn($option) => isset($option['match_id']));
        $variants = $question->options->filter(fn($option) => !isset($option['match_id']));
    @endphp
    <div>
        @foreach ($options as $option)
            <div class="flex items-center">
                <div class="mr-1 pr-1 font-bold border-r-4">{{ $loop->iteration }}</div>
                @isset($option->image)
                    <x-common.image :src="Storage::url($option->image)"></x-common.image>
                @endisset
                <div class="ml-1 my-2">{!! clean($option['text']) !!}</div>
            </div>
        @endforeach
    </div>
    <div>
        @foreach ($variants as $variant)
            <div class="flex items-center">
                <div class="mr-1 pr-1 font-bold border-r-4">{{ chr(65 + $loop->index) }}</div>
                @isset($variant->image)
                    <x-common.image :src="Storage::url($variant->image)"></x-common.image>
                @endisset
                <div class="ml-1 my-2">{!! clean($variant['text']) !!}</div>
            </div>
        @endforeach
    </div>
</div>