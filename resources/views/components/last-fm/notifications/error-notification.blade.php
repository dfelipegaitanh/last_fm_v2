<div
    x-show="$store.notifications.error"
    x-transition:enter="transition duration-300 ease-out"
    x-transition:enter-start="translate-y-2 opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition duration-200 ease-in"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-2 opacity-0"
    class="rounded-lg bg-red-50 p-4 text-sm text-red-500 shadow-lg ring-1 ring-red-500/10 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-400/10"
>
    <span x-text="$store.notifications.error"></span>
</div>
