<div
        wire:loading.class="disabled-div"
        class=" bg-white shadow-md rounded-lg overflow-hidden border border-gray-200
    p-6 {{ empty($lastFmUser) ? 'disabled-div' : '' }}">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">Información de LastFM</h2>
    <div wire:loading.remove>
    @if (!empty($lastFmUser))
        <p class="text-gray-600">Nombre del usuario: {{ $lastFmUser['name'] }}</p>
        <p class="text-gray-600">País: {{ $lastFmUser['country'] }}</p>
        <p class="text-gray-600">Fecha de registro: {{ $lastFmUser['registered'] }}</p>
    @else
        <p class="text-gray-500">La información del usuario de LastFM aún no está disponible.</p>
    @endif
    </div>
    <div class="flex justify-center items-center">
        <div wire:loading>
            <livewire:placeholder.spinner-body/>
        </div>
    </div>
</div>
