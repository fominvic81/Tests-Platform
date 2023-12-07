@props(['index', 'question', 'answer'])

<div class="my-4 shadow rounded-lg overflow-hidden">
    <div class="bg-white p-3">
        <div>
            <div class="inline-block border-2 px-2 rounded mr-2 font-mono font-bold">№{{ $index + 1 }}</div>
            <div class="inline-block border-2 px-2 rounded mr-2 font-mono font-semibold">@lang('question.type.'.$question->type->value)</div>
        </div>
        <div class="grid grid-cols-[auto_1fr]">
            @isset ($question->image)
                <x-common.image :src="App\Helpers\ImageHelper::url($question->image)"></x-common.image>
            @endisset
            <div class="ml-3 mt-1">{!! clean($question->text) !!}</div>
        </div>
        <hr class="my-3" />
        @if ($question->type === App\Enums\QuestionType::OneCorrect)<x-result.question.one-correct :question="$question" :answer="$answer"></x-result.question.one-correct>@endif
        @if ($question->type === App\Enums\QuestionType::MultipleCorrect)<x-result.question.multiple-correct :question="$question" :answer="$answer"></x-result.question.multiple-correct>@endif
        @if ($question->type === App\Enums\QuestionType::Match)<x-result.question.match :question="$question" :answer="$answer"></x-result.question.match>@endif
        @if ($question->type === App\Enums\QuestionType::TextInput)<x-result.question.text-input :question="$question" :answer="$answer"></x-result.question.text-input>@endif
        @if ($question->type === App\Enums\QuestionType::Sequence)<x-result.question.sequence :question="$question" :answer="$answer"></x-result.question.sequence>@endif
    </div>
    <div @class(['p-2 font-bold text-gray-700', 'bg-red-600' => ($answer->accuracy ?? 0) <= 0.4, 'bg-red-400' => ($answer->accuracy ?? 0) > 0.4 && ($answer->accuracy ?? 0) < 0.99,'bg-green-500' => ($answer->accuracy ?? 0) >= 0.99])>
        Бали: {{ round($answer->points ?? 0, 1) }} / {{ $question->points }}
    </div>
</div>