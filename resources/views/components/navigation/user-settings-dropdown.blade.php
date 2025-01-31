<div class="hidden sm:ms-6 sm:flex sm:items-center">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <x-button class="user-settings-button">
                <div
                    x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                    x-text="name"
                    x-on:profile-updated.window="name = $event.detail.name"
                ></div>
                <div class="ms-1">
                    <x-icon class="h-4 w-4 fill-current" stroke="" fill_rule="evenodd" clip_rule="evenodd">
                        <x-icons.down_arrow />
                    </x-icon>
                </div>
            </x-button>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link :href="route('profile')" wire:navigate>
                {{ __('Profile') }}
            </x-dropdown-link>
            <x-button wire:click="logout" class="w-full text-start">
                <x-dropdown-link>
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </x-button>
        </x-slot>
    </x-dropdown>
    <livewire:theme-toggle />
</div>
