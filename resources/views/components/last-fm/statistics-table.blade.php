<div
    x-show="$store.user.showStatistics"
    x-transition:enter="transition duration-300 ease-out"
    x-transition:enter-start="scale-95 transform opacity-0"
    x-transition:enter-end="scale-100 transform opacity-100"
    x-transition:leave="transition duration-200 ease-in"
    x-transition:leave-start="scale-100 transform opacity-100"
    x-transition:leave-end="scale-95 transform opacity-0"
    x-cloak
    class="mt-6"
>
    <div
        class="rounded-xl bg-white/80 p-6 shadow-lg ring-1 ring-gray-900/5 backdrop-blur-sm transition-all duration-300 dark:bg-gray-800/80 dark:ring-white/10"
    >
        <x-last-fm.tables.statistics-table />

        <x-last-fm.tables.pagination />
    </div>
</div>
