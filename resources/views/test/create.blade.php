<x-layouts.feed>
    {{-- <div id="test-create"></div> --}}

    <div class="w-full p-4 bg-white border shadow-md font-semibold">
        <form action="{{ route('test.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h1 class="m-auto text-2xl w-min whitespace-nowrap">Створити тест</h1>
            <div class="grid grid-cols-[1fr_auto] gap-3 items-center">
                <div>
                    <x-form.input name="name" label="Назва" placeholder="Назва" :value="old('name')"></x-form.input>

                    <x-form.textarea name="description" label="Опис" placeholder="Опис" :value="old('description')"></x-form.textarea>
                </div>
                <div class="w-40 h-40">
                    <x-form.image></x-form.image>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-x-3">
                <div>
                    <x-form.select name="course" label="Виберіть курс">
                        <option class="font-bold" value="">Без курсу</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected(strval($course->id) === (old('course') ?? Request::query('course')))>{{ $course->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-form.select name="accessibility" label="Доступність">
                            @foreach (App\Enums\Accessibility::cases() as $accessibility)
                            <option value="{{ $accessibility }}" @selected(strval($accessibility->value) === old('accessibility'))>@lang('accessibility.'.$accessibility->value)</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-form.select name="subject" label="Предмет">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(strval($subject->id) === old('subject'))>{{ $subject->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div>
                    <x-form.select name="grade" label="Клас">
                        @foreach ($grades as $grade)
                            <option value="{{ $grade->id }}" @selected(strval($grade->id) === old('grade'))>{{ $grade->name }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <x-form.errors></x-form.errors>
            <x-form.submit class="mt-2">Створити</x-form.submit>
        </form>
    </div>

</x-layouts.feed>