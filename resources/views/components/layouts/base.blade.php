@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $title ?? 'Title' }}</title>

    @viteReactRefresh()
    @vite('resources/css/app.css')
    @vite('resources/js/app.tsx')

</head>
<body {{ $attributes->merge(['class' => 'w-screen h-screen']) }}>
    {{ $slot }}
</body>
</html>