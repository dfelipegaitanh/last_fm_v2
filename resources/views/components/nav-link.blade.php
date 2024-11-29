@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-4 border-indigo-500 dark:border-indigo-700 text-sm font-medium leading-5 text-gray-900 dark:text-gray-200 hover:text-indigo-500 dark:hover:text-indigo-400 hover:transform hover:translate-y-1 focus:outline-none transition duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-500 hover:transform hover:translate-y-1 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
