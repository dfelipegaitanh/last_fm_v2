<x-app-layout>
    <div x-data class="relative">
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
            class="mt-6 rounded-lg bg-gray-100 p-4 shadow-md dark:border dark:border-gray-700 dark:bg-gray-900 dark:shadow-md dark:shadow-gray-900"
        >
            <h2 class="text-lg font-bold dark:text-white">Información del Usuario</h2>
            <template x-if="$store.user.info">
                <div class="mt-2">
                    <h3 class="text-md font-semibold dark:text-gray-300" x-text="$store.user.info.name"></h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Usuario desde:
                        <span x-text="$store.user.info.join_date"></span>
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Reproducciones totales:
                        <span x-text="$store.user.info.total_scrobbles"></span>
                    </p>
                </div>
            </template>
        </div>

        <!-- Tabla de estadísticas -->
        <div x-show="$store.user.showStatistics" x-transition.opacity.duration.300ms x-cloak class="mt-4">
            <div
                class="rounded-lg bg-gray-100 p-4 shadow-md dark:border dark:border-gray-700 dark:bg-gray-900 dark:shadow-md dark:shadow-gray-900"
            >
                <div class="overflow-hidden rounded-lg">
                    <table class="w-full rounded-lg bg-gray-50 text-left shadow-sm dark:bg-gray-700">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 dark:bg-gray-600 dark:text-gray-300">
                                <th class="px-4 py-2">Play Count</th>
                                <th class="px-4 py-2">Artist Count</th>
                                <th class="px-4 py-2">Track Count</th>
                                <th class="hide-on-mobile px-4 py-2">Album Count</th>
                                <th class="hide-on-mobile px-4 py-2">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in $store.user.statistics.data">
                                <tr
                                    class="odd:bg-gray-50 even:bg-white hover:bg-gray-100 dark:odd:bg-gray-700 dark:even:bg-gray-800 dark:hover:bg-gray-600"
                                >
                                    <td class="px-4 py-2 dark:text-gray-300" x-text="item.playcount"></td>
                                    <td class="px-4 py-2 dark:text-gray-300" x-text="item.artist_count"></td>
                                    <td class="px-4 py-2 dark:text-gray-300" x-text="item.track_count"></td>
                                    <td class="px-4 py-2 dark:text-gray-300" x-text="item.album_count"></td>
                                    <td class="px-4 py-2 dark:text-gray-300" x-text="item.created_at"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <nav class="mt-4 flex justify-center" aria-label="Pagination">
                    <template x-for="link in $store.user.statistics.links">
                        <button
                            x-on:click.prevent="link.url ? $store.user.fetchStatistics(link.url) : null"
                            :class="{
                                'bg-blue-500 text-white dark:bg-blue-600': link.active,
                                'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300': !link.active
                            }"
                            class="mx-1 rounded px-3 py-1"
                            x-html="link.label"
                        ></button>
                    </template>
                </nav>
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
                            .then((res) => {
                                if (!res.ok) throw new Error(`Error al obtener usuario: ${res.statusText}`);
                                return res.json();
                            })
                            .then((data) => (this.info = data))
                            .catch((error) => (this.errorMessage = error.message))
                            .finally(() => (this.loadingUserInfo = false));
                    },

                    fetchStatistics(url = this.apiRoutes.statistics) {
                        this.loadingStatistics = true;
                        fetch(url)
                            .then((res) => {
                                if (!res.ok) throw new Error(`Error al obtener estadísticas: ${res.statusText}`);
                                return res.json();
                            })
                            .then((data) => (this.statistics = data))
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
    </x-slot>
</x-app-layout>
