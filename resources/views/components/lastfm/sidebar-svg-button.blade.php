<a wire:navigate
   href="{{ route($route) }}"
   wire:loading.attr="disabled"
   class="px-5 py-3 bg-indigo-500 text-white font-medium rounded-md shadow-md
           hover:bg-indigo-400 hover:shadow-lg focus:outline-none focus:ring-4
           focus:ring-indigo-300 focus:ring-opacity-50 active:bg-indigo-600
           active:ring-indigo-400 text-center transition duration-300 transform active:scale-90
           justify-center gap-2 inline-flex items-center">
    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="{{ $slot }}">
        </path>
    </svg>
    {{ $text }}
</a>
