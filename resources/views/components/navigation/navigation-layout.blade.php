<nav
    x-data="{ open: false }"
    class="border-b border-gray-100 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
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
