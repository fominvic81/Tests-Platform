@props(['question', 'answer'])

<div>
    <div><span class="font-semibold">Ваша відповідь:</span> {{ $answer->data['texts'][0] ?? '' }}</div>
    <div class="font-semibold">Правильні відповіді:</div>
    <ul>
        @foreach ($question->data['answer']['texts'] as $text)
            <li>{{ $text }}</li>
        @endforeach
    </ul>
</div>