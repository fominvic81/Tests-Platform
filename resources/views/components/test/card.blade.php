@props(['test'])

<div class="bg-emerald-100 odd:bg-yellow-50 p-3 shadow-md rounded-md grid grid-cols-[auto_1fr_auto] gap-3">
    <x-common.image :src="App\Helpers\ImageHelper::url($test->image, URL::to('/images/img-placeholder.png'))"></x-common.image>
    <div>
        <a class="text-lg font-semibold" href="{{ route('test.show', $test->id) }}">{{ $test->name }}</a>
        <div>
            <a href="{{ route('user.show', $test->user->id) }}" class="text-blue-600 hover:underline hover:text-blue-400 text-lg font-semibold">{{ $test->user->fullname }}</a>
        </div>
        <div>
            {{ $test->questions()->count() }} Завдань,
            @isset($test->subject)
                {{ $test->subject->name }},
            @endisset
            @isset($test->grade)
                {{ $test->grade->name }}
            @endisset
        </div>
        <div class="hidden sm:block">{!! $test->description !!}</div>
    </div>
    <div class="m-1">
        @auth
            <x-button.save
                :saved="Auth::user()->savedTests()->where('test_id', $test->id)->exists()"
                :url="route('test.save', $test->id)"
            ></x-button.save>
        @endauth
    </div>
</div>