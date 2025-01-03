<button wire:click="$set('filter', '{{ $filter }}')"
        class="flex items-center px-6 py-3 {{ $filter == Str::lower($text) ? 'bg-red-600' : 'bg-indigo-500' }} text-white font-medium rounded-md hover:bg-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition">
    {{ $text }}
</button>
