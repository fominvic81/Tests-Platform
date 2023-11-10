<x-layouts.feed title="Створити курс">
    <div class="w-full p-4 bg-white border shadow-md font-semibold">
        <form class="w-full h-full" method="POST" action="{{ route('course.store') }}" enctype="multipart/form-data">
            @csrf
            <h1 class="m-auto text-2xl w-min whitespace-nowrap">Створити курс</h1>
            @include('course.inc.form')
            <x-form.submit class="col-span-full mt-3">Створити</x-form.submit>
        </form>
    </div>
</x-layouts.feed>