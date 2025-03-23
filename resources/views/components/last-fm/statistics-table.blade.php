@props([
    'statistics',
])

<div
    class="relative overflow-hidden rounded-xl border border-gray-200/50 bg-white/30 shadow-sm dark:border-gray-800/50 dark:bg-gray-900/30"
>
    <table class="min-w-full divide-y divide-gray-200/50 dark:divide-gray-800/50">
        <thead>
            <tr>
                <th
                    class="bg-gray-50/80 px-4 py-3.5 text-left text-sm font-medium text-gray-900 dark:bg-gray-800/80 dark:text-white"
                >
                    Play Count
                </th>
                <th
                    class="bg-gray-50/80 px-4 py-3.5 text-left text-sm font-medium text-gray-900 dark:bg-gray-800/80 dark:text-white"
                >
                    Artist Count
                </th>
                <th
                    class="bg-gray-50/80 px-4 py-3.5 text-left text-sm font-medium text-gray-900 dark:bg-gray-800/80 dark:text-white"
                >
                    Track Count
                </th>
                <th
                    class="hide-on-mobile bg-gray-50/80 px-4 py-3.5 text-left text-sm font-medium text-gray-900 dark:bg-gray-800/80 dark:text-white"
                >
                    Album Count
                </th>
                <th
                    class="hide-on-mobile bg-gray-50/80 px-4 py-3.5 text-left text-sm font-medium text-gray-900 dark:bg-gray-800/80 dark:text-white"
                >
                    Created At
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200/50 dark:divide-gray-800/50">
            <template x-for="item in $store.user.statistics.data">
                <tr
                    class="group transition-all duration-200 hover:bg-indigo-50/90 hover:shadow-sm dark:hover:bg-indigo-500/20"
                >
                    <td
                        class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        x-text="item.playcount"
                    ></td>
                    <td
                        class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        x-text="item.artist_count"
                    ></td>
                    <td
                        class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        x-text="item.track_count"
                    ></td>
                    <td
                        class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        x-text="item.album_count"
                    ></td>
                    <td
                        class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        x-text="item.created_at"
                    ></td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
