<div class="container mx-auto p-10">
    <div class="flex flex-row space-x-4">

        <div class="w-1/4 flex items-center justify-center">
            <button wire:click="getUser"
                    class="{{ $buttonClasses }}">
                Get User Info
            </button>
        </div>

        <div class="w-3/4">
            <livewire:last-fm.user-info/>
        </div>


    </div>

