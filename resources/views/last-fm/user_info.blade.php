<x-app-layout>
    <div x-data="fetchTableData()" class="relative">
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <!-- Botones principales -->
        <div class="flex items-center space-x-4">
            <!-- Botón para cargar la información del usuario -->
            <button @click="fetchUserInfo" x-show="!userDataLoaded" class="buttons">
                <template x-if="loadingUserInfo">
                    <x-spinner />
                </template>
                <span x-text="loadingUserInfo ? 'Cargando usuario...' : 'Mostrar Información del Usuario'"></span>
            </button>

            <button
                x-show="userInfo"
                @click="toggleStatistics"
                :class="showStatistics ? 'buttons--active' : 'buttons--default'"
                class="buttons"
                x-cloak
            >
                <template x-if="loadingStatistics">
                    <!-- Agregar un contenedor padre -->
                    <div class="flex items-center gap-2">
                        <x-spinner/>
                        <span>Cargando estadísticas...</span>
                    </div>
                </template>

                <span x-show="!loadingStatistics"
                      x-text="showStatistics ? 'Ocultar Tabla' : 'Mostrar Tabla de Estadísticas'"></span>
            </button>
        </div>

        <!-- Contenedor de Información del Usuario -->
        <div x-show="userInfo" x-transition.opacity.duration.300ms class="mt-6 rounded-md bg-gray-100 p-4 shadow">
            <h2 class="text-lg font-bold">Información del Usuario</h2>
            <template x-if="userInfo">
                <div class="mt-2">
                    <h3 class="text-md font-semibold" x-text="userInfo.name"></h3>
                    <p class="text-sm text-gray-600">
                        Usuario desde:
                        <span x-text="userInfo.join_date"></span>
                    </p>
                    <p class="text-sm text-gray-600">
                        Reproducciones totales:
                        <span x-text="userInfo.total_scrobbles"></span>
                    </p>
                </div>
            </template>
        </div>

        <!-- Tabla de estadísticas -->
        <div x-show="showStatistics" x-transition.opacity.duration.300ms x-cloak class="mt-4">
            <table class="w-full rounded-md bg-gray-50 text-left shadow-sm dark:bg-gray-700">
                <thead>
                <tr class="bg-gray-200 text-gray-600 dark:bg-gray-600 dark:text-gray-300">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Edad</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="item in tableData" :key="item.id">
                    <tr>
                        <td class="px-4 py-2" x-text="item.id"></td>
                        <td class="px-4 py-2" x-text="item.nombre"></td>
                        <td class="px-4 py-2" x-text="item.edad"></td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('fetchTableData', () => {
                const headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                };

                return {
                    showStatistics: false,
                    loadingUserInfo: false,
                    loadingStatistics: false,
                    errorMessage: '',
                    userDataLoaded: false,
                    userInfo: null,
                    tableData: [],

                    apiCall(url) {
                        return fetch(url, {method: 'GET', headers}).then((response) => {
                            if (!response.ok) {
                                throw new Error(`Error al consultar ${url}`);
                            }
                            return response.json();
                        });
                    },

                    fetchUserInfo() {
                        this.loadingUserInfo = true;
                        this.errorMessage = '';

                        this.apiCall('{{ route('last-fm.user_get_info') }}')
                            .then((data) => {
                                this.userInfo = data; // Muestra la información del usuario en el contenedor
                                this.userDataLoaded = true;
                            })
                            .catch(() => {
                                this.errorMessage = 'No se pudo cargar la información del usuario. Intenta nuevamente.';
                            })
                            .finally(() => {
                                this.loadingUserInfo = false;
                            });
                    },

                    fetchStatistics() {
                        this.loadingStatistics = true;
                        this.errorMessage = '';

                        this.apiCall('{{ route('last-fm.user_get_statistics') }}')
                            .then((data) => {
                                this.tableData = data;
                                this.showStatistics = true;
                            })
                            .catch(() => {
                                this.errorMessage = 'No se pudieron cargar las estadísticas. Intenta nuevamente.';
                            })
                            .finally(() => {
                                this.loadingStatistics = false;
                            });
                    },

                    toggleStatistics() {
                        if (!this.showStatistics) {
                            this.fetchStatistics(); // Cargar datos solo si la tabla no está visible
                        } else {
                            this.showStatistics = false; // Ocultar tabla si ya está visible
                        }
                    },
                };
            });
        });
    </script>
</x-app-layout>
