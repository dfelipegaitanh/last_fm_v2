<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="space-y-1 pb-3 pt-2">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
    </div>
    <div class="border-t border-gray-200 pb-1 pt-4 dark:border-gray-600">
        <div class="px-4">
            <div
                class="text-base font-medium text-gray-800 dark:text-gray-200"
                x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                x-text="name"
                x-on:profile-updated.window="name = $event.detail.name"
            ></div>
            <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
        </div>
        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile')" wire:navigate>
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <button wire:click="logout" class="w-full text-start">
                <x-responsive-nav-link>
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </button>
        </div>
    </div>
</div>
