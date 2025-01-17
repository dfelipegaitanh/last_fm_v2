<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <x-logo />
                <x-nav-links />
            </div>
            <x-settings-dropdown />
            <x-hamburger-menu />
        </div>
    </div>
    <x-responsive-menu />
</nav>
