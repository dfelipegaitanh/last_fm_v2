<x-app-layout>
    <div x-data="fetchTableData()" class="relative">
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        <div class="flex items-center">
            <button
                @click="toggleStatistics"
                :disabled="loadingStatistics"
                :class="showStatistics ? 'buttons--active' : 'buttons--default'"
                class="buttons inline-flex items-center"
            >
                <template x-if="loadingStatistics">
                    <x-spinner />
                </template>
                <span
                    x-text="
                        loadingStatistics
                            ? 'Cargando estadísticas...'
                            : showStatistics
                              ? 'Ocultar Tabla'
                              : 'Mostrar Tabla'
                    "
                ></span>
            </button>

            <button
                x-show="showStatistics && !showUserModal"
                @click="toggleUserModal"
                :disabled="loadingUserInfo"
                class="ml-auto inline-flex items-center rounded-full border-none bg-blue-400 p-1 transition-colors duration-200 hover:bg-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800"
            >
                <template x-if="loadingUserInfo">
                    <x-spinner />
                </template>
                <template x-if="!loadingUserInfo">
                    <svg
                        class="h-5 w-5 text-white"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>
                </template>
            </button>
        </div>

        <div x-show="errorMessage" class="mt-4 text-red-500">
            <span x-text="errorMessage"></span>
        </div>

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

        <div
            x-show="showUserModal"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-cloak
        >
            <div class="relative w-11/12 rounded-lg bg-white p-6 shadow-lg md:w-1/2">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-xl font-bold">Información del Usuario</h2>
                    <button @click="toggleUserModal" class="text-2xl text-gray-600 hover:text-gray-900">&times;</button>
                </div>
                <div>
                    <template x-if="loadingUserInfo">
                        <div class="flex justify-center">
                            <x-spinner />
                        </div>
                    </template>
                    <template x-if="!loadingUserInfo && userInfo">
                        <div>
                            <h3 class="text-lg font-semibold" x-text="userInfo.name"></h3>
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
            </div>
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
                    showUserModal: false,
                    loadingStatistics: false,
                    loadingUserInfo: false,
                    errorMessage: '',
                    userInfo: null,
                    tableData: [],

                    apiCall(url) {
                        return fetch(url, { method: 'GET', headers }).then((response) => {
                            if (!response.ok) {
                                throw new Error(`Error al consultar ${url}`);
                            }
                            return response.json();
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

                    fetchUserInfo() {
                        this.loadingUserInfo = true;
                        this.errorMessage = '';

                        this.apiCall('{{ route('last-fm.user_get_info') }}')
                            .then((data) => {
                                this.userInfo = data;
                                this.showUserModal = true;
                            })
                            .catch(() => {
                                this.errorMessage = 'No se pudo cargar la información del usuario. Intenta nuevamente.';
                            })
                            .finally(() => {
                                this.loadingUserInfo = false;
                            });
                    },

                    toggleStatistics() {
                        this.showStatistics ? this.resetStatistics() : this.fetchStatistics();
                    },

                    toggleUserModal() {
                        this.showUserModal = !this.showUserModal;
                        if (!this.showUserModal) {
                            this.userInfo = null;
                        } else if (!this.userInfo) {
                            this.fetchUserInfo();
                        }
                    },

                    resetStatistics() {
                        this.showStatistics = false;
                        this.showUserModal = false;
                        this.userInfo = null;
                        this.tableData = [];
                    },
                };
            });
        });
    </script>
</x-app-layout>
