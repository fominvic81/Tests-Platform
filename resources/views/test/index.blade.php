<x-layouts.feed>
    @foreach ($tests as $test)
        <a class="block" href="{{ route('test.show', $test->id) }}">{{ $test->name }}</a>
    @endforeach
    {{ $tests->links() }}
</x-layouts.feed>