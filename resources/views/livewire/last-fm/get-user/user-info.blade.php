<div wire:loading.class="disabled-div"
     class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6">
    <div class="flex flex-col items-center justify-center text-center transition-all duration-500 ease-in-out overflow-hidden
        {{ !empty($lastFmUser) ? 'max-h-0 opacity-0' : 'max-h-screen opacity-100 py-2' }}">
        <x-empty-state message="LastFM user information is not available yet."/>
        <button wire:click.debounce="$dispatch('userInfo:updateLastFmUser')"
                wire:loading.attr="disabled"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 mt-2 rounded-md">
            <span wire:loading.remove>Fetch Information</span>
            <span wire:loading>Fetching information...</span>
        </button>
    </div>
    <div wire:loading.remove>
        <div class="mb-4">
            @if (!empty($lastFmUser))
                <p class="text-gray-600">User Name: {{ $lastFmUser->name }}</p>
                <p class="text-gray-600">Country: {{ $lastFmUser->country }}</p>
                <p class="text-gray-600">Registration Date: {{ $lastFmUser->registered }}</p>
                <livewire:last-fm.statistics.global-statistics :lastFmUser="$lastFmUser"/>

                <div class="flex justify-end mt-6">
                    <button wire:click.debounce="$dispatch('userInfo:clearLastFmUser')"
                            wire:loading.attr="disabled"
                            class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-6 rounded-md">
                        <span wire:loading.remove>Clear</span>
                        <span wire:loading>Clearing...</span>
                    </button>
                </div>
            @endif
        </div>
    </div>


    <div class="flex justify-center items-center">
        <div wire:loading>
            <livewire:placeholder.spinner-body/>
        </div>
    </div>

</div>
