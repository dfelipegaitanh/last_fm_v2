<x-app-layout>
    <div x-data="fetchTableData">
        <!-- Botón dinámico para mostrar/ocultar la tabla -->
        <button
            @click="toggleTable()"
            :disabled="loading"
            :class="showTable ? 'buttons--active' : 'buttons--default'"
            class="buttons inline-flex items-center"
        >
            <template x-if="loading">
                <x-spinner />
            </template>

            <span x-text="loading ? 'Cargando...' : (showTable ? 'Cerrar Tabla' : 'Mostrar Tabla')"></span>

            <template x-if="showTable && !loading">
                <x-icon d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </template>
        </button>

        <!-- Mensaje de error -->
        <div x-show="errorMessage" class="mt-4 text-red-500">
            <span x-text="errorMessage"></span>
        </div>

        <!-- Contenedor de la tabla con transición -->
        <div x-show="showTable" x-transition.opacity.duration.300ms x-cloak class="mt-4">
            <table class="w-full rounded-md bg-gray-50 text-left shadow-sm dark:bg-gray-700">
                <thead>
                <tr class="bg-gray-200 text-gray-600 dark:bg-gray-600 dark:text-gray-300">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Edad</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="(item, index) in tableData" :key="index">
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
            Alpine.data('fetchTableData', () => ({
                showTable: false,
                loading: false, // Estado de carga
                errorMessage: '', // Mensaje de error
                tableData: [],
                debounceTimeout: null, // Para evitar múltiples llamadas a la API

                // Alternar visibilidad de la tabla y manejar datos
                toggleTable() {
                    if (this.showTable) {
                        this.showTable = false; // Ocultar tabla
                        this.tableData = []; // Vaciar datos
                    } else {
                        clearTimeout(this.debounceTimeout);
                        this.debounceTimeout = setTimeout(() => {
                            this.fetchTableData();
                        }, 500); // Espera 500ms antes de hacer la solicitud
                    }
                },

                // Obtener datos dinámicos desde la API
                async fetchTableData() {
                    this.loading = true; // Activar loader en el botón
                    this.errorMessage = ''; // Limpiar error

                    try {
                        const response = await fetch('{{ route('last-fm.user_get_statistics') }}', {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                                Accept: 'application/json',
                            },
                        });

                        if (!response.ok) throw new Error('Error al obtener los datos');

                        const data = await response.json();
                        this.tableData = data; // Asignar los datos a la tabla
                        this.showTable = true; // Mostrar la tabla
                    } catch (error) {
                        this.errorMessage = 'No se pudo cargar los datos. Intenta nuevamente.';
                        console.error('Error:', error);
                    } finally {
                        this.loading = false; // Desactivar loader en el botón
                    }
                },
            }));
        });
    </script>
</x-app-layout>
