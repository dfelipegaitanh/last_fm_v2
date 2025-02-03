<x-app-layout>
    <div x-data="fetchTableData">
        <h2 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-300">Contenedor con Botón</h2>

        <!-- Botón dinámico para mostrar/ocultar la tabla -->
        <button
            @click="toggleTable()"
            :class="showTable ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600'"
            class="buttons flex items-center space-x-2 rounded-md px-4 py-2 text-white transition"
        >
            <span x-text="showTable ? 'Cerrar Tabla' : 'Mostrar Tabla'"></span>
            <!-- Ícono SVG que solo aparece cuando el texto es "Cerrar Tabla" -->
            <template x-if="showTable">
                <x-icon d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </template>
        </button>

        <!-- Contenedor de la tabla con transición -->
        <div x-show="showTable" x-transition.opacity.duration.300ms x-cloak class="mt-4">
            <!-- Tabla -->
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
                tableData: [],

                // Alternar visibilidad de la tabla y manejar datos
                toggleTable() {
                    if (this.showTable) {
                        this.showTable = false; // Ocultar tabla
                        this.tableData = []; // Vaciar datos
                    } else {
                        this.fetchTableData(); // Cargar datos y mostrar tabla
                    }
                },

                // Obtener datos dinámicos desde la API
                async fetchTableData() {
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
                        console.error('Error:', error);
                    }
                },
            }));
        });
    </script>
</x-app-layout>
