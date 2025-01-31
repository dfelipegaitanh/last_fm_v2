<div
    wire:loading.class="disabled-div"
    class="overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-md dark:border-gray-700 dark:bg-gray-800"
>
    <div
        class="{{ ! empty($lastFmUser) ? 'max-h-0 opacity-0' : 'max-h-screen py-2 opacity-100' }} flex flex-col items-center justify-center overflow-hidden text-center transition-all duration-500 ease-in-out"
    >
        <x-empty-state message="LastFM user information is not available yet.">
            M20 16v-4a8 8 0 1 0-16 0v4m16 0v2a2 2 0 0 1-2 2h-2v-6h2a2 2 0 0 1 2 2ZM4 16v2a2 2 0 0 0 2 2h2v-6H6a2 2 0 0
            0-2 2Z
        </x-empty-state>
        <button
            wire:click.debounce="$dispatch('userInfo:updateLastFmUser')"
            wire:loading.attr="disabled"
            class="mt-2 rounded-md bg-blue-500 px-6 py-2 font-medium text-white hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800"
        >
            <span wire:loading.remove>Fetch Information</span>
            <span wire:loading>Fetching information...</span>
        </button>
    </div>
    <div wire:loading.remove>
        <div class="mb-4">
            @if (! empty($lastFmUser))
                <p class="text-gray-600 dark:text-gray-300">User Name: {{ $lastFmUser->name }}</p>
                <p class="text-gray-600 dark:text-gray-300">Country: {{ $lastFmUser->country }}</p>
                <p class="text-gray-600 dark:text-gray-300">Registration Date: {{ $lastFmUser->registered }}</p>
                <livewire:last-fm.statistics.global-statistics :lastFmUser="$lastFmUser" />

                <div class="mt-6 flex justify-end">
                    <button
                        wire:click.debounce="$dispatch('userInfo:clearLastFmUser')"
                        wire:loading.attr="disabled"
                        class="rounded-md bg-red-500 px-6 py-2 font-medium text-white hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800"
                    >
                        <span wire:loading.remove>Clear</span>
                        <span wire:loading>Clearing...</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="flex items-center justify-center">
        <div wire:loading>
            <livewire:placeholder.spinner-body />
        </div>
    </div>
</div>
