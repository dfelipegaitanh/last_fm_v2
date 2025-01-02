<a wire:navigate
   href="{{ route($route) }}"
   wire:loading.attr="disabled"
   class="w-full px-5 py-3 bg-{{ $color }}-500 text-white font-medium rounded-md shadow-md hover:bg-{{ $color }}-400 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-{{ $color }}-300 focus:ring-opacity-50 active:bg-{{ $color }}-600 active:ring-{{ $color }}-400 text-center transition duration-300 transform active:scale-90 flex items-center justify-center gap-2">
    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="{{ $slot }}">
        </path>
    </svg>
    {{ $text }}
</a>
