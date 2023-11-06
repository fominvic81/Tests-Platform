<x-layouts.feed>
    <div class="grid grid-cols-[auto_1fr_auto] p-5 bg-white shadow-md rounded-lg">
        @isset($test->image)
            <x-common.image :src="App\Helpers\ImageHelper::url($test->image)"></x-common.image>
        @endisset
        <div>
            <h1 class="text-2xl">{{ $test->name }}</h1>
            <div>
                @if($test->subject_id > 1)
                    {{ $test->subject->name }}
                @endif
                @if($test->grade_id > 1)
                    {{ $test->grade->name }}
                @endif
            </div>
            <span>Автор: </span><a href="" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->user->fullname }}</a>
            <br>
            @isset($test->course)
                <span>Курс: </span><a href="{{ route('course.show', $test->course->id) }}" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->course->name }}</a>
            @endisset
        </div>
        <div class="grid grid-flow-col">
            @auth
                @if (Auth::user()->id === $test->user_id)
                    <a class="block w-10 h-10 rounded-md border-2 hover:bg-gray-200" href="{{ route('test.edit', $test->id) }}"><x-svg path="common/edit.svg"></x-svg></a>
                    @endif
            @endauth
        </div>
        <div class="col-span-3">{!! $test->description !!}</div>
    </div>
    <div class="grid grid-cols-2 mt-4 gap-2 text-3xl font-semibold">
        <a class="py-3 rounded-md bg-white shadow border-2 flex items-center justify-center" href="{{ route('test.exam.create', $test->id) }}" >Задати домашнє завдання</a>
        <a class="py-3 rounded-md bg-white shadow border-2 flex items-center justify-center" href="">Пройти</a>
    </div>
    <div>
        @foreach ($test->questions as $question)
            <x-question :index="$loop->index" :question="$question"></x-question>
        @endforeach
    </div>
</x-layouts.feed>