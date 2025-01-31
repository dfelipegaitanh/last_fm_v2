<div class="{{ empty($lastFmUser) ? 'hidden' : '' }} mt-4">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
            <thead class="bg-gray-200 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                        Play Count
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                        Album Count
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                        Artist Count
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                        Created At
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->statistics as $statistic)
                    <tr
                        class="{{ $loop->even ? 'bg-gray-50 dark:bg-gray-800' : 'bg-white dark:bg-gray-900' }} hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $statistic->playcount }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $statistic->album_count }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $statistic->artist_count }}
                        </td>
                        <td class="px-6 py-4">{{ $statistic->created_at }}1</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
