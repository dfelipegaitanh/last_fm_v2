<div wire:loading.class="disabled-div"
     class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6 ">
    <div wire:loading.class="disabled-div"
         class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6 relative">

        <div class="flex">
            <!-- Barra Lateral con Botones -->
            <div class="w-1/5 bg-gray-100 p-6 flex flex-col space-y-4 border-r">
                <x-fetch-song-button text="Daily"
                                     filter="{{ $filter }}">
                </x-fetch-song-button>

                <x-fetch-song-button text="Weekly"
                                     filter="{{ $filter }}">
                </x-fetch-song-button>

                <x-fetch-song-button text="Monthly"
                                     filter="{{ $filter }}">
                </x-fetch-song-button>

                <x-fetch-song-button text="Yearly"
                                     filter="{{ $filter }}">
                </x-fetch-song-button>

                <x-fetch-song-button text="Chart"
                                     filter="{{ $filter }}">
                </x-fetch-song-button>

            </div>

            <div class="w-4/5 bg-gray-50 p-8">
                <!-- Encabezado -->
                <h2 class="text-3xl font-semibold text-gray-800 mb-6">Songs Chart</h2>

                <!-- Tabla de Resultados -->
                <div class="w-full bg-white shadow-md rounded-lg overflow-hidden border-4 border-transparent hover:border-indigo-500
                        transition-all p-6">
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
            </div>
        </div>
    </div>

    <div class="flex justify-center items-center h-screen">
        <div wire:loading>
            <livewire:placeholder.spinner-body/>
        </div>
    </div>
</div>
