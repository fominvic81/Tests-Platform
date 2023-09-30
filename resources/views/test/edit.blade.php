<x-layouts.feed>
    {{-- <div id="test-editor"></div> --}}
    <div class="p-5 bg-white shadow-md">
        <form action="{{ route('test.update', $test->id) }}" method="POST">
            @csrf
            @method("PUT")
    
            <x-form.input name="name" label="Назва" value="{{ old('name') ?? $test->name }}">Назва</x-form.input>
    
            <x-form.text name="description" label="Опис" value="{{ old('description') ?? $test->description }}">Опис</x-form.text>

            <x-form.select name="course" label="Курс">
                <option class="font-bold" value="0">Без курсу</option>
                @foreach (Auth::user()->courses as $course)
                    <option value="{{ $course->id }}" @selected((old('course') ?? $test->course->id) === $course->id)>{{ $course->name }}</option>
                @endforeach
            </x-form.select>
    
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <x-form.select name="subject" label="Предмет">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected((old('subject') ?? $test->subject->id) === $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-form.select name="grade" label="Предмет">
                        @foreach ($grades as $grade)
                            <option value="{{ $grade->id }}" @selected((old('grade') ?? $test->grade->id) === $grade->id)>{{ $grade->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
    
            <x-form.submit>Зберегти</x-form.submit>
        </form>
    </div>
    
    <div>
        {{-- {questions.map((question, index) =>
            <QuestionComponent
                key={question.id}
                question={question}
                index={index}
                onDelete={async () => {
                    if (await deleteQuestion(question.id)) {
                        setQuestions([...questions.filter(({ id }) => id !== question.id)]);
                    }
                }}
            ></QuestionComponent>
        )} --}}
        @foreach ($test->questions as $question)
            {{-- {{ $question->text }} --}}
            <x-question :question="$question" :index="$loop->index"></x-question>
        @endforeach
    </div>
</x-layouts.feed>
