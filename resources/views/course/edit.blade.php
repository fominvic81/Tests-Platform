{{-- <x-layouts.feed>
    <div id="course-edit"></div>
</x-layouts.feed> --}}

<x-layouts.feed>
    <div class="w-full p-4 bg-white border shadow-md font-semibold">
        <form class="w-full h-full" method="POST" action="{{ route('course.update', $course->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h1 class="m-auto text-2xl w-min whitespace-nowrap">Редагувати курс</h1>
            @include('course.inc.form')
            <x-form.submit class="col-span-full mt-3">Зберегти</x-form.submit>
        </form>
    </div>
</x-layouts.feed>