<div wire:loading.class="disabled-div"
     class=" bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6">
    <div class="{{ empty($lastFmUser) ? 'disabled-div' : '' }}">
        <div class="flex flex-col items-center justify-center text-center py-8 {{ !empty($lastFmUser) ? 'hidden' : '' }} ">
            <svg class="w-16 h-16 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 17v-4H5v4m14 0v-4h-4v4m4 0h-4m4 0a2 2 0 100-4 2 2 0 100 4zM5 17a2 2 0 100-4 2 2 0 100 4zM5 13v-2a7 7 0 0114 0v2"></path>
            </svg>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                <p class="text-gray-500">La información del usuario de LastFM aún no está disponible.</p>
            </div>
        </div>
        <div wire:loading.remove>
            <div class="mb-4">
                @if (!empty($lastFmUser))
                    <p class="text-gray-600">Nombre del usuario: {{ $lastFmUser->name }}</p>
                    <p class="text-gray-600">País: {{ $lastFmUser->country }}</p>
                    <p class="text-gray-600">Fecha de registro: {{ $lastFmUser->registered }}</p>
                    <livewire:last-fm.statistics.global-statistics :lastFmUser="$lastFmUser"/>
                @endif
            </div>
        </div>


        <div class="flex justify-center items-center">
            <div wire:loading>
                <livewire:placeholder.spinner-body/>
            </div>
        </div>
    </div>

</div>
