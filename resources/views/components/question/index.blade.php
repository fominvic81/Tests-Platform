@props(['index', 'question'])

<div class="bg-white p-3 my-4 shadow">
    <div>
        <div class="flex justify-between">
            <div>
                <code class="bg-gray-200 border border-gray-300 px-2 rounded mr-2">№{{ $index + 1 }}</code>
                <span class="text-lg indent-2">{{ $question->text }}</span>
            </div>
            <div>
                <a href="" class="mx-2 p-1 bg-sky-500 hover:bg-sky-600 border border-gray-500 rounded">Редагувати</a>
                <button class="mx-2 p-1 bg-sky-500 hover:bg-sky-600 border border-gray-500 rounded" onClick={onDelete}>Видалити</button>
            </div>
        </div>
        <hr class="my-3" />
        {{-- <Component question={ question }></Component> --}}
        @if ($question->type === App\Enums\QuestionType::OneCorrect)<x-question.one-correct :question="$question"></x-question.one-correct>@endif
    </div>
</div>