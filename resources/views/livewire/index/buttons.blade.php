<div class="overflow-hidden flex flex-col gap-4 justify-start mb-4 w-full max-w-md">
    <button wire:click.debounce="$dispatch('userInfo:updateLastFmUser')"
            type="button"
            class="w-full px-5 py-3 bg-indigo-500 text-white font-medium rounded-md shadow-md hover:bg-indigo-400 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-50 active:bg-indigo-600 active:ring-purple-400 transition duration-300 transform active:scale-95">
        Get User Info
    </button>

    <button wire:click.debounce="$dispatch('userInfo:fetchSongs')"
            type="button"
            class="w-full px-5 py-3 bg-indigo-500 text-white font-medium rounded-md shadow-md hover:bg-indigo-400 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-purple-300 focus:ring-opacity-50 active:bg-indigo-600 active:ring-purple-400 transition duration-300 transform active:scale-95">
        Traer canciones
    </button>

    <button wire:click.debounce="$dispatch('userInfo:clearLastFmUser')"
            type="button"
            class="w-full px-5 py-3 bg-red-500 text-white font-medium rounded-md shadow-md hover:bg-red-400 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-pink-300 focus:ring-opacity-50 active:bg-red-600 active:ring-pink-400 transition duration-300 transform active:scale-95">
        Clear
    </button>
</div>
