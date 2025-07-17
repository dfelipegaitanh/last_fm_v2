@props([
    'user',
])

<div
    x-show="$store.user.info"
    x-transition:enter="transition duration-300 ease-out"
    x-transition:enter-start="scale-95 transform opacity-0"
    x-transition:enter-end="scale-100 transform opacity-100"
    x-transition:leave="transition duration-200 ease-in"
    x-transition:leave-start="scale-100 transform opacity-100"
    x-transition:leave-end="scale-95 transform opacity-0"
    class="mt-6 overflow-hidden rounded-2xl border border-gray-200/50 bg-white/50 p-6 shadow-xl shadow-gray-200/50 ring-1 ring-gray-200/50 backdrop-blur-xl transition-all duration-300 dark:border-gray-800/50 dark:bg-gray-900/50 dark:shadow-gray-950/50 dark:ring-gray-800/50"
>
    <h2
        class="bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-xl font-medium tracking-tight text-transparent dark:from-indigo-400 dark:to-purple-400"
    >
        Información del Usuario
    </h2>

    <div class="mt-2">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white" x-text="$store.user.info.name"></h3>
        <div class="mt-2 space-y-1">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Usuario desde:
                <span
                    class="font-medium text-gray-900 transition-colors duration-200 dark:text-white"
                    x-text="$store.user.info.join_date"
                ></span>
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Reproducciones totales:
                <span
                    class="font-medium text-gray-900 transition-colors duration-200 dark:text-white"
                    x-text="$store.user.info.total_scrobbles"
                ></span>
            </p>
        </div>
    </div>
</div>
