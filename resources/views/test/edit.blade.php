<x-layouts.feed>
    <div id="test-editor"></div>
    {{-- <div class="p-5 bg-white shadow-md">
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
    
            <x-form.submit1>Зберегти</x-form.submit1>
        </form>
    </div>
    
    <div>
        @foreach ($test->questions as $question)
            <x-question :question="$question" :index="$loop->index"></x-question>
        @endforeach
    </div>

    <a href="{{ route('test.question.create', $test->id) }}" class="flex justify-center items-center text-2xl p-5 mb-5 bg-gray-50 hover:bg-gray-100 border-2 border-gray-200">
        Створити питання
    </a> --}}
</x-layouts.feed>
