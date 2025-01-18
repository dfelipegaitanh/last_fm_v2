<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }">
    <x-navigation.primary-navigation-menu>
        <div class="flex">
            <x-navigation.logo/>
            <x-navigation.nav-links/>
        </div>
        <x-navigation.user-settings-dropdown/>
        <x-navigation.hamburger-menu/>
        <x-navigation.responsive-menu/>
    </x-navigation.primary-navigation-menu>
</nav>
