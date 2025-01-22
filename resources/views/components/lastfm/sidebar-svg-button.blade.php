<a wire:navigate
   href="{{ route($route) }}"
   wire:loading.attr="disabled"
   class="buttons"
>

    <x-icon class="w-5 h-5"
            viewBox="0 0 24 24"
            fill="none"
            stroke_linecap="round"
            stroke_linejoin="round"
            stroke_width="2"
    >
        {{ $slot }}
    </x-icon>
    {{ $text }}
</a>
