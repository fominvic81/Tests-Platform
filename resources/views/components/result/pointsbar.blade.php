@props(['stats'])

@php
    $percentCorrect = round($stats['correct'] / $stats['max'] * 100);
    $percentWrong = round($stats['wrong'] / $stats['max'] * 100);
    $separator = $percentCorrect > 0 && $percentWrong > 0;
@endphp
<div {{ $attributes->merge(['class' => 'flex h-8 bg-gray-200 rounded overflow-hidden font-bold text-gray-200 border-2 border-gray-400'])}}>
    <div class="h-full flex items-center justify-center bg-green-500 border-gray-800{{ $separator ? ' border-r' : '' }}" style="width: {{ $percentCorrect * 1.001 }}%">{{ $percentCorrect > 5 ? "$percentCorrect%" : null }}</div>
    <div class="h-full flex items-center justify-center bg-red-600" style="width: {{ $percentWrong }}%">{{ $percentWrong > 5 ? "$percentWrong%" : null }}</div>
</div>