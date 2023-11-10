<x-layouts.feed :title="$title">
    <h1 class="mx-2 text-3xl font-bold text-gray-600">{{ $title }}</h1>
    <form>
        <div class="grid grid-cols-3 md:grid-cols-4 gap-4 items-center justify-items-start mx-2 mb-5 text-lg font-semibold">
            <x-form.select name="subject" label="Предмет" wrap-class="w-full">
                <option value="">...</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected(Request::query('subject') === strval($subject->id))>{{ $subject->name }}</option>
                @endforeach
            </x-form.select>
            <x-form.select name="grade" label="Клас"  wrap-class="w-full">
                <option value="">...</option>
                @foreach ($grades as $grade)
                    <option value="{{ $grade->id }}" @selected(Request::query('grade') === strval($grade->id))>{{ $grade->name }}</option>
                @endforeach
            </x-form.select>
            <button class="px-4 md:px-16 py-2 bg-yellow-300 rounded text-yellow-800 hover:brightness-95">Знайти</button>
        </div>
    </form>
    <div class="grid gap-5">
        @foreach ($tests as $test)
            <x-test.card :test="$test"></x-test.card>
        @endforeach
        {{ $tests->links() }}
    </div>
</x-layouts.feed>