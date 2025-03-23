@props([
    'active',
])

@php
    $classes =
        $active ?? false
            ? 'relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-900 transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-center after:scale-x-100 after:bg-indigo-500 after:transition-transform dark:text-white dark:after:bg-indigo-400'
            : 'relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 transition-all duration-300 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:origin-center after:scale-x-0 after:bg-gray-300 after:transition-transform hover:text-gray-900 hover:after:scale-x-100 dark:text-gray-400 dark:after:bg-gray-700 dark:hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
