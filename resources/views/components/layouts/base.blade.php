@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $title ?? 'Title' }}</title>

    @viteReactRefresh()
    @vite('resources/css/app.css')
    @vite('resources/js/app.tsx')

</head>
<body {{ $attributes->merge(['class' => 'w-screen h-screen text-md']) }}>
    {{ $slot }}
</body>
</html>