@props([
    'links',
])

<nav class="mt-4 flex justify-center" aria-label="Pagination">
    <template x-for="link in $store.user.statistics.links">
        <button
            x-on:click.prevent="link.url ? $store.user.fetchStatistics(link.url) : null"
            :class="{
                'border-indigo-500 bg-indigo-500/10 text-indigo-700 dark:border-indigo-400 dark:bg-indigo-400/10 dark:text-indigo-300': link.active,
                'border-gray-200 bg-white text-gray-600 hover:border-gray-300 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:bg-gray-700': !link.active
            }"
            class="mx-1 rounded-md border px-3 py-1.5 text-sm font-medium shadow-sm transition-all duration-200 hover:shadow focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:ring-offset-1 dark:focus:ring-indigo-400/50 dark:focus:ring-offset-gray-900"
            x-html="link.label"
        ></button>
    </template>
</nav>
