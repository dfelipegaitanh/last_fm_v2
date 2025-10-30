<button
    x-show="$store.user.info"
    @click="$store.user.toggleStatistics()"
    :class="$store.user.showStatistics ? 'border-red-200 bg-red-500/10 text-red-700 hover:bg-red-500/20 dark:border-red-500/20 dark:bg-red-500/20 dark:text-red-300 dark:hover:bg-red-500/30 dark:focus:ring-red-400/50' : ''"
    class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-500/10 px-4 py-2.5 text-sm font-medium text-indigo-700 shadow-sm transition-all duration-200 hover:bg-indigo-500/20 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-offset-2 dark:border-indigo-500/20 dark:bg-indigo-500/20 dark:text-indigo-300 dark:hover:bg-indigo-500/30 dark:focus:ring-indigo-400/50 dark:focus:ring-offset-gray-900"
    :disabled="$store.user.loadingStatistics"
    x-cloak
>
    <template x-if="$store.user.loadingStatistics">
        <div class="flex items-center gap-2">
            <x-spinner />
            <span>Cargando tu historial musical...</span>
        </div>
    </template>
    <template x-if="!$store.user.loadingStatistics">
        <div class="flex items-center gap-2">
            <x-icons.chart-bar x-show="!$store.user.showStatistics" class="h-5 w-5" />
            <x-icons.x-mark x-show="$store.user.showStatistics" class="h-5 w-5" />
            <span
                x-text="
                    $store.user.showStatistics
                        ? 'Ocultar mi historial musical'
                        : 'Ver mi historial musical'
                "
            ></span>
        </div>
    </template>
</button>
