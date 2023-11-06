@props(['path'])

@php
    $svg = new DOMDocument();
    $svg->load(resource_path('svg/'.$path));
    echo $svg->saveXML($svg->documentElement);
@endphp
