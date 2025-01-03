<div class="w-4/5 bg-gray-50 p-8">

    <div class="flex flex-col items-center justify-center text-center transition-all duration-500 ease-in-out overflow-hidden
        {{ !empty($filter) ? 'max-h-0 opacity-0' : 'max-h-screen opacity-100 py-2' }}">
        <x-empty-state message="Not data shown.">
            M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75
            0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125
            1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12
            18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504
            1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125
            1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621
            0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25
            0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504
            1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125
            12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504
            1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125
            1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5
        </x-empty-state>

    </div>

    <div wire:loading.remove
         class="w-full bg-white shadow-md rounded-lg overflow-hidden border-4 border-transparent hover:border-blue-500 transition-all p-6
         {{ empty($filter) ? ' hidden' : '' }}">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">
            {{ ucfirst($filter) }} Songs Chart
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto transition-opacity duration-500 ease-in-out"
                   wire:loading.class="opacity-50">
                <thead class="bg-gray-100 border-b-2 border-gray-300">
                <tr>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">#</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Song</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Artist</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Album</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Date</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Plays</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-4">1</td>
                    <td class="py-4 px-4">Blinding Lights</td>
                    <td class="py-4 px-4">The Weeknd</td>
                    <td class="py-4 px-4">After Hours</td>
                    <td class="py-4 px-4">2025-01-01</td>
                    <td class="py-4 px-4">542</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center items-center">
        <div wire:loading>
            <livewire:placeholder.spinner-body/>
        </div>
    </div>

</div>
