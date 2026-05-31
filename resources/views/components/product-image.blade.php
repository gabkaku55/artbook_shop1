@props([
    'path' => null,
    'alt' => '',
    'class' => 'w-full h-full object-cover',
])

@php
    $url = \App\Support\MediaUrl::resolve($path);
@endphp

@if($url)
    <img {{ $attributes->merge(['class' => $class, 'src' => $url, 'alt' => $alt]) }}>
@else
    <div {{ $attributes->merge(['class' => 'w-full h-full flex items-center justify-center text-gray-600 bg-gray-800']) }}>
        <i class="fas fa-image text-4xl opacity-20"></i>
    </div>
@endif
