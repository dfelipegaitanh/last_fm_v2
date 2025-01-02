<div class="overflow-hidden flex flex-col gap-4 justify-start mb-4 w-full max-w-md">
    <a wire:click.debounce="$dispatch('userInfo:updateLastFmUser')"
       wire:navigate
       href="{{route('last-fm.get-user')}}"
       class="w-full px-5 py-3 bg-indigo-500 text-white font-medium rounded-md shadow-md hover:bg-indigo-400 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-50 active:bg-indigo-600 active:ring-purple-400 text-center transition duration-300 transform active:scale-95">
        Get User Info
    </a>

    <a wire:click.debounce="$dispatch('getSongs:fetchSongs', { type : 'daily' })"
       wire:navigate
       href="{{ route('last-fm.get-songs') }}"
       class="w-full px-5 py-3 bg-indigo-500 text-white font-medium rounded-md shadow-md hover:bg-indigo-400 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-50 active:bg-indigo-600 active:ring-purple-400 text-center transition duration-300 transform active:scale-95">
        Traer canciones
    </a>

    @if(false)
    <a wire:click.debounce="$dispatch('userInfo:clearLastFmUser')"
            type="button"
       class="w-full px-5 py-3 bg-red-500 text-white font-medium rounded-md shadow-md hover:bg-red-400 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-pink-300 focus:ring-opacity-50 active:bg-red-600 active:ring-pink-400 text-center transition duration-300 transform active:scale-95">
        Clear
    </a>
    @endif
</div>
