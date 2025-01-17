<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('last-fm.get-user')" :active="request()->routeIs('last-fm.get-user')" wire:navigate>
        {{ __('Inicio') }}
    </x-nav-link>
</div>
