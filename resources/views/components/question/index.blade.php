@props(['index', 'question'])

<div class="bg-white p-3 my-4 shadow rounded-lg">
    <div>
        <div>
            <div class="inline-block border-2 px-2 rounded mr-2 font-mono font-semibold">Завдання №{{ $index + 1 }}</div>
            <div class="inline-block border-2 px-2 rounded mr-2 font-mono font-semibold">@lang('question.type.'.$question->type->value)</div>
        </div>
        <div class="grid grid-cols-[auto_1fr]">
            @isset ($question->image)
                <x-common.image :src="App\Helpers\ImageHelper::url($question->image)"></x-common.image>
            @endisset
            <div class="ml-3 mt-1">{!! clean($question->text) !!}</div>
        </div>
        <hr class="my-3" />
        @if ($question->type === App\Enums\QuestionType::OneCorrect)<x-question.one-correct :question="$question"></x-question.one-correct>@endif
        @if ($question->type === App\Enums\QuestionType::MultipleCorrect)<x-question.multiple-correct :question="$question"></x-question.multiple-correct>@endif
        @if ($question->type === App\Enums\QuestionType::Match)<x-question.match :question="$question"></x-question.match>@endif
        @if ($question->type === App\Enums\QuestionType::TextInput)<x-question.text-input :question="$question"></x-question.text-input>@endif
        @if ($question->type === App\Enums\QuestionType::Sequence)<x-question.sequence :question="$question"></x-question.sequence>@endif
    </div>
</div>