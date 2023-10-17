@props(['index', 'question'])

<div class="bg-white p-3 my-4 shadow">
    <div>
        <div>
            <div class="inline-block bg-gray-200 border border-gray-300 px-2 rounded mr-2 font-mono w-fit">Завдання №{{ $index + 1 }}</div>
            <div class="inline-block bg-gray-200 border border-gray-300 px-2 rounded mr-2 font-mono w-fit">@lang('question.type.'.$question->type->value)</div>
        </div>
        <div class="grid grid-cols-[auto_1fr]">
            @isset ($question->image)
                <x-question.image :src="Storage::url($question->image)"></x-question.image>
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