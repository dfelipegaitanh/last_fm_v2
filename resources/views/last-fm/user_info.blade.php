<x-app-layout>
    <div x-data x-init class="relative">
        <style>
            [x-cloak] {
                display: none !important;
            }

            @media (max-width: 640px) {
                .hide-on-mobile {
                    display: none;
                }
            }
        </style>

        <!-- Botones principales -->
        <div class="flex flex-wrap items-center gap-4 sm:flex-nowrap">
            <!-- Botón para cargar la información del usuario -->
            <button
                @click="$store.user.fetchUserInfo()"
                x-show="!$store.user.info"
                class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-500/10 px-4 py-2.5 text-sm font-medium text-indigo-700 shadow-sm transition-all duration-200 hover:bg-indigo-500/20 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-offset-2 dark:border-indigo-500/20 dark:bg-indigo-500/20 dark:text-indigo-300 dark:hover:bg-indigo-500/30 dark:focus:ring-indigo-400/50 dark:focus:ring-offset-gray-900"
            >
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
                :class="$store.user.showStatistics ? 'border-red-200 bg-red-500/10 text-red-700 hover:bg-red-500/20 dark:border-red-500/20 dark:bg-red-500/20 dark:text-red-300 dark:hover:bg-red-500/30 dark:focus:ring-red-400/50' : ''"
                class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-500/10 px-4 py-2.5 text-sm font-medium text-indigo-700 shadow-sm transition-all duration-200 hover:bg-indigo-500/20 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-offset-2 dark:border-indigo-500/20 dark:bg-indigo-500/20 dark:text-indigo-300 dark:hover:bg-indigo-500/30 dark:focus:ring-indigo-400/50 dark:focus:ring-offset-gray-900"
                :disabled="$store.user.loadingStatistics"
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
        <x-last-fm.user-info-card />

        <!-- Tabla de estadísticas -->
        <div
            x-show="$store.user.showStatistics"
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="scale-95 transform opacity-0"
            x-transition:enter-end="scale-100 transform opacity-100"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="scale-100 transform opacity-100"
            x-transition:leave-end="scale-95 transform opacity-0"
            x-cloak
            class="mt-6"
        >
            <div
                class="rounded-xl bg-white/80 p-6 shadow-lg ring-1 ring-gray-900/5 backdrop-blur-sm transition-all duration-300 dark:bg-gray-800/80 dark:ring-white/10"
            >
                <x-last-fm.statistics-table />

                <x-last-fm.pagination />
            </div>
        </div>

        <!-- Contenedor de errores -->
        <div x-show="$store.user.errorMessage" class="mt-2 text-red-500 dark:text-red-400">
            <span x-text="$store.user.errorMessage"></span>
        </div>
    </div>

    <x-slot name="script">
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
                            .then(res => {
                                if (!res.ok) throw new Error(`Error al obtener usuario: ${res.statusText}`);
                                return res.json();
                            })
                            .then(data => (this.info = data))
                            .catch(error => (this.errorMessage = error.message))
                            .finally(() => (this.loadingUserInfo = false));
                    },

                    fetchStatistics(url = this.apiRoutes.statistics) {
                        this.loadingStatistics = true;
                        fetch(url)
                            .then(res => {
                                if (!res.ok) throw new Error(`Error al obtener estadísticas: ${res.statusText}`);
                                return res.json();
                            })
                            .then(data => (this.statistics = data))
                            .catch(error => (this.errorMessage = error.message))
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
    </x-slot>
</x-app-layout>
