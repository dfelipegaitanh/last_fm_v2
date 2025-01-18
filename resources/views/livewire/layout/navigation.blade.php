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
    <div class="nav__container">
        <div class="flex justify-between h-16">
            <div class="nav__left">
                <x-navigation.logo/>
                <x-navigation.nav-links/>
            </div>
            <div class="nav__right">
                <x-navigation.user-settings-dropdown/>
                <x-navigation.hamburger-menu/>
                <x-navigation.responsive-menu/>
            </div>
        </div>
    </div>
</nav>
