<button
    x-show="$store.user.info"
    @click="$store.user.refreshData()"
    class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-500/10 px-4 py-2.5 text-sm font-medium text-emerald-700 shadow-sm transition-all duration-200 hover:bg-emerald-500/20 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-offset-2 dark:border-emerald-500/20 dark:bg-emerald-500/20 dark:text-emerald-300 dark:hover:bg-emerald-500/30 dark:focus:ring-emerald-400/50 dark:focus:ring-offset-gray-900"
    :disabled="$store.user.loadingUserInfo || $store.user.loadingStatistics"
    x-cloak
>
    <template x-if="$store.user.loadingUserInfo || $store.user.loadingStatistics">
        <div class="flex items-center gap-2">
            <x-spinner />
            <span>Actualizando datos...</span>
        </div>
    </template>
    <template x-if="!$store.user.loadingUserInfo && !$store.user.loadingStatistics">
        <div class="flex items-center gap-2">
            <x-icons.refresh class="h-5 w-5" />
            <span>Actualizar datos</span>
        </div>
    </template>
</button>
