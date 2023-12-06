<x-layouts.feed :title="$test->name">
    <div class="grid grid-cols-[auto_1fr_auto] p-5 bg-white shadow-md rounded-lg">
        <div>
            @isset($test->image)
                <x-common.image :src="App\Helpers\ImageHelper::url($test->image)"></x-common.image>
            @endisset
        </div>
        <div>
            <h1 class="text-2xl">{{ $test->name }}</h1>
            <div>
                @isset($test->subject)
                    {{ $test->subject->name }}
                @endisset
                @isset($test->grade)
                    {{ $test->grade->name }}
                @endisset
            </div>
            <span>Автор: </span><a href="{{ route('user.show', $test->user->id) }}" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->user->fullname }}</a>
            <br>
            @isset($test->course)
                <span>Курс: </span><a href="{{ route('course.show', $test->course->id) }}" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->course->name }}</a>
            @endisset
        </div>
        <div class="grid grid-flow-col gap-1">
            @auth
                @can('update', $test)
                    <a
                        href="{{ route('test.edit', $test->id) }}"
                        class="block w-9 h-9 rounded-md border-2 hover:bg-gray-200"
                    ><x-svg path="common/edit.svg"></x-svg></a>
                @endif
                <x-button.save
                    :saved="Auth::user()->savedTests()->where('test_id', $test->id)->exists()"
                    :url="route('test.save', $test->id)"
                ></x-button.save>
            @endauth
        </div>
        <div class="col-span-3">{!! $test->description !!}</div>
    </div>
    @if (count($test->questions) > 0)
        <div class="grid grid-cols-2 mt-4 gap-2 text-3xl font-semibold">
            <a class="py-3 rounded-md bg-white shadow border-2 flex items-center justify-center" href="{{ route('test.exam.create', $test->id) }}" >Задати</a>
            <a class="py-3 rounded-md bg-white shadow border-2 flex items-center justify-center" href="">Пройти</a>
        </div>
    @endif
    <div>
        @foreach ($test->questions as $question)
            <x-question :index="$loop->index" :question="$question"></x-question>
        @endforeach
    </div>
</x-layouts.feed>