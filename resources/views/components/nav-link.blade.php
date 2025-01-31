@props([
    'active',
])

@php
    $classes = $active ?? false ? 'nav__link--active ' : 'nav__link--inactive ';
@endphp

<a {{ $attributes->merge(['class' => "nav__link $classes"]) }}>
    {{ $slot }}
</a>
