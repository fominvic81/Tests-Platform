<button
    type="submit"
    {{ $attributes->merge(['class' => 'w-full py-1 bg-sky-500 border border-blue-400 rounded']) }}
>{{ $slot }}</button>