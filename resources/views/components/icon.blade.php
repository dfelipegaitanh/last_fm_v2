@props([
    'd',
    'class' => 'h-6 w-6 text-white',
])

<svg
    class="{{ $class }}"
    aria-hidden="true"
    xmlns="http://www.w3.org/2000/svg"
    width="24"
    height="24"
    fill="none"
    viewBox="0 0 24 24"
>
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $d }}" />
</svg>
