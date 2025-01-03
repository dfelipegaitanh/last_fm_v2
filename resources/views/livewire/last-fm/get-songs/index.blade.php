    <div wire:loading.class="disabled-div"
         class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6 relative">

        <div class="flex">

            @if(false)
                <livewire:last-fm.get-songs.buttons :filter="$reportType"/>
            @endif
            <!-- Barra Lateral con Botones -->
            <div class="w-1/5 bg-gray-100 p-6 flex flex-col space-y-4 border-r">
                <button wire:click="$set('reportType', 'daily')"
                        class="flex items-center px-6 py-3
                           {{ $reportType == 'daily' ? 'bg-red-600' : 'bg-blue-500' }}
                           text-white font-medium rounded-md hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">
                    Daily
                </button>

                <button wire:click="$set('reportType', 'weekly')"
                        class="flex items-center px-6 py-3
                           {{ $reportType == 'weekly' ? 'bg-red-600' : 'bg-blue-500' }}
                           text-white font-medium rounded-md hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">
                    Weekly
                </button>

                <button wire:click="$set('reportType', 'monthly')"
                        class="flex items-center px-6 py-3
                           {{ $reportType == 'monthly' ? 'bg-red-600' : 'bg-blue-500' }}
                           text-white font-medium rounded-md hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">
                    Monthly
                </button>

                <button wire:click="$set('reportType', 'yearly')"
                        class="flex items-center px-6 py-3
                           {{ $reportType == 'yearly' ? 'bg-red-600' : 'bg-blue-500' }}
                           text-white font-medium rounded-md hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">
                    Yearly
                </button>

                <button wire:click="$set('reportType', 'chart')"
                        class="flex items-center px-6 py-3
                           {{ $reportType == 'chart' ? 'bg-red-600' : 'bg-blue-500' }}
                           text-white font-medium rounded-md hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 transition">
                    Chart
                </button>
            </div>

            <livewire:last-fm.get-songs.list-chart :reportType="$reportType"/>

        </div>
    </div>
