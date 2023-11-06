<x-layouts.feed>
    @foreach ($courses as $course)
        <div class="bg-white p-3 my-4 shadow grid grid-cols-[auto_1fr] gap-3">
            <x-common.image :src="isset($course->image) ? App\Helpers\ImageHelper::url($course->image) : URL::to('/images/img-placeholder.png')"></x-common.image>
            <div>
                <a class="text-lg" href="{{ route('course.show', $course->id) }}">{{ $course->name }}</a>
                <div>
                    <span>Автор: </span><a href="" class="text-blue-600 hover:underline hover:text-blue-400">{{ $course->user->fullname }}</a>
                </div>
                <div>{!! $course->description !!}</div>
            </div>
        </div>
    @endforeach
    {{ $courses->links() }}
    <div class="my-5"></div>
</x-layouts.feed>