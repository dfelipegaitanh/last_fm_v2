<div class=" bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">Información de LastFM {{ collect($lastFmUser)->toJson() }}</h2>
    @if (!empty($lastFmUser))
        <p class="text-gray-600">Nombre del usuario: {{ $lastFmUser['name'] }}</p>
        <p class="text-gray-600">País: {{ $lastFmUser['country'] }}</p>
        <p class="text-gray-600">Fecha de registro: {{ $lastFmUser['registered'] }}</p>
    @else
        <p class="text-gray-500">La información del usuario de LastFM aún no está disponible.</p>
    @endif
</div>
