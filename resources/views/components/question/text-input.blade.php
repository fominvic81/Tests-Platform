@props(['question'])

<div>
    @foreach ($question->options as $option)
        <div class='my-2 border-l-4 pl-2'>{{ $option->text }}</div>
    @endforeach
</div>