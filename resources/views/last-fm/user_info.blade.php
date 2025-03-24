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

        <!-- Título y descripción -->
        <div class="mb-6 text-center">
            <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Tu Historial Musical en Last.fm</h1>
            <p class="text-gray-600 dark:text-gray-400">
                Explora tus artistas favoritos, canciones más escuchadas y descubre tus patrones musicales
            </p>
        </div>

        <!-- Botones principales -->
        <div class="flex flex-wrap items-center gap-4 sm:flex-nowrap" x-data>
            <!-- Botón inicial -->
            <x-last-fm.buttons.user-info.init-button />

            <!-- Botón de estadísticas -->
            <x-last-fm.buttons.user-info.statistics-button />

            <!-- Botón de refrescar -->
            <x-last-fm.buttons.user-info.refresh-button />
        </div>

        <!-- Mensaje de bienvenida -->
        <div
            x-show="!$store.user.info"
            class="mt-6 rounded-xl bg-white/80 p-6 text-center shadow-sm ring-1 ring-gray-900/5 backdrop-blur-sm dark:bg-gray-800/80 dark:ring-white/10"
        >
            <p class="text-gray-600 dark:text-gray-400">
                Bienvenido a tu dashboard de Last.fm. Conecta tu perfil para comenzar a explorar tu historial musical y
                descubrir interesantes estadísticas sobre tus gustos musicales.
            </p>
        </div>

        <!-- Contenedor de Información del Usuario -->
        <x-last-fm.user-info-card />

        <!-- Tabla de estadísticas -->
        <x-last-fm.statistics-table />

        <!-- Contenedor de notificaciones -->
        <x-last-fm.notifications />
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('alpine:init', () => {
                // Store para el manejo de errores y notificaciones
                Alpine.store('notifications', {
                    error: null,
                    success: null,
                    showError(message) {
                        this.error = message;
                        setTimeout(() => (this.error = null), 3000);
                    },
                    showSuccess(message) {
                        this.success = message;
                        setTimeout(() => (this.success = null), 3000);
                    },
                });

                // Store para las llamadas a la API
                Alpine.store('api', {
                    routes: {
                        userInfo: @json(route('last-fm.user_get_info')),
                        statistics: @json(route('last-fm.user_get_statistics')),
                    },

                    async fetchWithInterceptor(url) {
                        try {
                            const response = await fetch(url);
                            if (!response.ok) {
                                throw new Error(`Error HTTP: ${response.status}`);
                            }
                            return await response.json();
                        } catch (error) {
                            Alpine.store('notifications').showError(error.message);
                            throw error;
                        }
                    },
                });

                // Store principal del usuario
                Alpine.store('user', {
                    // Estado
                    info: null,
                    statistics: [],
                    loadingUserInfo: false,
                    loadingStatistics: false,
                    showStatistics: false,

                    // Getters
                    get isLoading() {
                        return this.loadingUserInfo || this.loadingStatistics;
                    },

                    // Métodos
                    async fetchUserInfo() {
                        try {
                            this.loadingUserInfo = true;
                            this.info = await Alpine.store('api').fetchWithInterceptor(
                                Alpine.store('api').routes.userInfo
                            );
                        } catch (error) {
                            this.info = null;
                        } finally {
                            this.loadingUserInfo = false;
                        }
                    },

                    async fetchStatistics(url = null) {
                        try {
                            this.loadingStatistics = true;
                            this.statistics = await Alpine.store('api').fetchWithInterceptor(
                                url || Alpine.store('api').routes.statistics
                            );
                        } catch (error) {
                            this.statistics = [];
                        } finally {
                            this.loadingStatistics = false;
                        }
                    },

                    toggleStatistics() {
                        if (!this.showStatistics) {
                            this.fetchStatistics();
                        }
                        this.showStatistics = !this.showStatistics;
                    },

                    async refreshData() {
                        try {
                            this.loadingUserInfo = true;
                            this.loadingStatistics = true;

                            // Actualizar información del usuario
                            this.info = await Alpine.store('api').fetchWithInterceptor(
                                Alpine.store('api').routes.userInfo
                            );

                            // Actualizar estadísticas
                            if (this.showStatistics) {
                                this.statistics = await Alpine.store('api').fetchWithInterceptor(
                                    Alpine.store('api').routes.statistics
                                );
                            }

                            // Mostrar notificación de éxito
                            Alpine.store('notifications').showSuccess('Datos actualizados correctamente');
                        } catch (error) {
                            // Mantener datos existentes en caso de error
                            Alpine.store('notifications').showError('Error al actualizar los datos');
                        } finally {
                            this.loadingUserInfo = false;
                            this.loadingStatistics = false;
                        }
                    },
                });
            });
        </script>
    </x-slot>
</x-app-layout>
