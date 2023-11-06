<x-layouts.feed>
    @foreach ($tests as $test)
        <div class="bg-white p-3 my-4 shadow grid grid-cols-[auto_1fr] gap-3">
            <x-common.image :src="isset($test->image) ? App\Helpers\ImageHelper::url($test->image) : URL::to('/images/img-placeholder.png')"></x-common.image>
            <div>
                <a class="text-lg" href="{{ route('test.show', $test->id) }}">{{ $test->name }}</a>
                <div>
                    <span>Автор: </span><a href="" class="text-blue-600 hover:underline hover:text-blue-400">{{ $test->user->fullname }}</a>
                </div>
                <div>{!! $test->description !!}</div>
            </div>
        </div>
    @endforeach
    {{ $tests->links() }}
    <div class="my-5"></div>
</x-layouts.feed>