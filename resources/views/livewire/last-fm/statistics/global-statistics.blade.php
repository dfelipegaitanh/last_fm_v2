<div class="mt-4 {{ empty($lastFmUser) ? 'hidden' : '' }} ">

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Play Count
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Album Count
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artist
                    Count
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->statistics as $statistic)
                <tr class="{{ $loop->even ? 'bg-gray-50 dark:bg-gray-800' : 'bg-white dark:bg-gray-900' }} hover:bg-gray-100 dark:hover:bg-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $statistic->playcount }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $statistic->album_count }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $statistic->artist_count }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $statistic->created_at }}1
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
