<button
    @click="$store.user.fetchUserInfo()"
    x-show="!$store.user.info"
    class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-500/10 px-4 py-2.5 text-sm font-medium text-indigo-700 shadow-sm transition-all duration-200 hover:bg-indigo-500/20 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-offset-2 dark:border-indigo-500/20 dark:bg-indigo-500/20 dark:text-indigo-300 dark:hover:bg-indigo-500/30 dark:focus:ring-indigo-400/50 dark:focus:ring-offset-gray-900"
>
    <template x-if="$store.user.loadingUserInfo">
        <div class="flex items-center gap-2">
            <x-spinner />
            <span>Conectando con Last.fm...</span>
        </div>
    </template>
    <template x-if="!$store.user.loadingUserInfo">
        <div class="flex items-center gap-2">
            <x-icons.lastfm class="h-5 w-5" />
            <span>Conectar con mi perfil de Last.fm</span>
        </div>
    </template>
</button>
