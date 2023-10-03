@props(['index', 'question'])

<div class="bg-white p-3 my-4 shadow">
    <div>
        <div class="flex justify-between">
            <div class="bg-gray-200 border border-gray-300 px-2 rounded mr-2 font-mono">Завдання №{{ $index + 1 }}</div>
            <div>
                <a href="" class="mx-2 p-1 bg-sky-500 hover:bg-sky-600 border border-gray-500 rounded">Редагувати</a>
                <form class="inline mx-2 p-1 bg-sky-500 hover:bg-sky-600 border border-gray-500 rounded" action="{{ route('question.destroy', $question->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Видалити</button>
                </form>
            </div>
        </div>
        <div class="grid grid-cols-[auto_1fr]">
            @if ($question->image)
                <div class="w-40 h-full min-h-[160px] py-3">
                    <img class="w-full h-full object-contain" src="{{ Storage::url($question->image) }}" alt="Зображення">
                </div>
            @endif
            <div class="ml-3 mt-1">{!! clean($question->text) !!}</div>
        </div>
        <hr class="my-3" />
        @if ($question->type === App\Enums\QuestionType::OneCorrect)<x-question.one-correct :question="$question"></x-question.one-correct>@endif
    </div>
</div>