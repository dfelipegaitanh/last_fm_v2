<div class="nav__links-wrapper">
    <x-nav-link :href="route('last-fm.get-user')" :active="request()->routeIs('last-fm.get-user')" wire:navigate>
        {{ __('Inicio') }}
    </x-nav-link>

    <x-nav-link :href="route('last-fm.get-user')" :active="false">
        {{ __('Otro') }}
    </x-nav-link>
</div>
