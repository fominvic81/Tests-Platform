@props(['question', 'answer'])

<div>
    @foreach ($question->data['options'] as $option)
        <div class="flex items-center">
            @php
                $correct = $question->data['answer']['correct'][$loop->index];
                $chosen = $answer->data['correct'][$loop->index] ?? false;
            @endphp
            <div @class(['w-5 h-5 rounded-full mr-1', 'bg-gray-300' => !$correct, 'bg-green-500' => $correct])></div>
            @isset($option['image'])
                <x-common.image :src="App\Helpers\ImageHelper::url($option['image'])"></x-common.image>
            @endisset
            <div class='ml-1 my-2'>{!! clean($option['text']) !!}</div>
            @if ($chosen)
                <div @class(['font-semibold', 'text-red-400' => !$correct, 'text-green-500' => $correct])>&MediumSpace;- Ваша відповідь</div>
            @endif
        </div>
    @endforeach
</div>