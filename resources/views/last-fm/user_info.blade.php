<x-app-layout>
    <div x-data class="relative">
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <!-- Botones principales -->
        <div class="flex items-center space-x-4">
            <!-- Botón para cargar la información del usuario -->
            <button @click="$store.user.fetchUserInfo()" x-show="!$store.user.info" class="buttons">
                <template x-if="$store.user.loadingUserInfo">
                    <x-spinner />
                </template>
                <span
                    x-text="
                        $store.user.loadingUserInfo
                            ? 'Cargando usuario...'
                            : 'Mostrar Información del Usuario'
                    "
                ></span>
            </button>

            <button
                x-show="$store.user.info"
                @click="$store.user.toggleStatistics()"
                :class="$store.user.showStatistics ? 'buttons--active' : 'buttons--default'"
                class="buttons"
                x-cloak
            >
                <template x-if="$store.user.loadingStatistics">
                    <div class="flex items-center gap-2">
                        <x-spinner />
                        <span>Cargando estadísticas...</span>
                    </div>
                </template>

                <span
                    x-show="!$store.user.loadingStatistics"
                    x-text="$store.user.showStatistics ? 'Ocultar Tabla' : 'Mostrar Tabla de Estadísticas'"
                ></span>
            </button>
        </div>

        <!-- Contenedor de Información del Usuario -->
        <div
            x-show="$store.user.info"
            x-transition.opacity.duration.300ms
            class="mt-6 rounded-md bg-gray-100 p-4 shadow"
        >
            <h2 class="text-lg font-bold">Información del Usuario</h2>
            <template x-if="$store.user.info">
                <div class="mt-2">
                    <h3 class="text-md font-semibold" x-text="$store.user.info.name"></h3>
                    <p class="text-sm text-gray-600">
                        Usuario desde:
                        <span x-text="$store.user.info.join_date"></span>
                    </p>
                    <p class="text-sm text-gray-600">
                        Reproducciones totales:
                        <span x-text="$store.user.info.total_scrobbles"></span>
                    </p>
                </div>
            </template>
        </div>

        <!-- Tabla de estadísticas -->
        <div x-show="$store.user.showStatistics" x-transition.opacity.duration.300ms x-cloak class="mt-4">
            <table class="w-full rounded-md bg-gray-50 text-left shadow-sm dark:bg-gray-700">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 dark:bg-gray-600 dark:text-gray-300">
                        <th class="px-4 py-2">1</th>
                        <th class="px-4 py-2">2</th>
                        <th class="px-4 py-2">3</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="item in $store.user.statistics" >
                        <tr>
                            <td class="px-4 py-2" x-text="item.playcount"></td>
                            <td class="px-4 py-2" x-text="item.artist_count"></td>
                            <td class="px-4 py-2" x-text="item.track_count"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Contenedor de errores -->
        <div x-show="$store.user.errorMessage" class="mt-2 text-red-500">
            <span x-text="$store.user.errorMessage"></span>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('user', {
                info: null,
                statistics: [],
                loadingUserInfo: false,
                loadingStatistics: false,
                showStatistics: false,
                errorMessage: '',

                apiRoutes: {
                    userInfo: @json(route('last-fm.user_get_info')),
                    statistics: @json(route('last-fm.user_get_statistics')),
                },

                fetchUserInfo() {
                    this.loadingUserInfo = true;
                    fetch(this.apiRoutes.userInfo)
                        .then((res) => {
                            if (!res.ok) throw new Error(`Error al obtener usuario: ${res.statusText}`);
                            return res.json();
                        })
                        .then((data) => (this.info = data))
                        .catch((error) => (this.errorMessage = error.message))
                        .finally(() => (this.loadingUserInfo = false));
                },

                fetchStatistics() {
                    this.loadingStatistics = true;
                    fetch(this.apiRoutes.statistics)
                        .then((res) => {
                            if (!res.ok) throw new Error(`Error al obtener estadísticas: ${res.statusText}`);
                            return res.json();
                        })
                        .then(function(data) {
                            this.statistics = data.data
                            console.log(this.statistics)
                        })
                        .catch((error) => (this.errorMessage = error.message))
                        .finally(() => (this.loadingStatistics = false));
                },

                toggleStatistics() {
                    if (!this.showStatistics) {
                        this.fetchStatistics();
                    }
                    this.showStatistics = !this.showStatistics;
                },
            });
        });
    </script>
</x-app-layout>
