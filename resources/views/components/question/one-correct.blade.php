@props(['question'])

<div class='grid grid-cols-2'>
    @foreach ($question->data['options'] as $option)
        <div class="flex items-center my-2 before:block before:w-5 before:h-5 before:rounded-full {{ $option['correct'] ? 'before:bg-green-500' : 'before:bg-gray-300' }} before:mr-1">
            {{ $option['text'] }}
        </div>
    @endforeach
</div>