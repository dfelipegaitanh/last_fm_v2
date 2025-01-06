<div wire:loading.class="disabled-div"
     class="bg-white dark:bg-gray-800 shadow-md rounded-xl overflow-hidden border-x-2 border-gray-200 dark:border-gray-700 p-6 relative">

    <div class="flex">
        @if(false)
            <livewire:last-fm.get-songs.buttons :filter="$reportType"/>
        @endif

        <!-- Barra Lateral con Botones -->
        <div class="w-1/5 bg-gray-50 dark:bg-gray-800 shadow-md p-8 rounded-xl border-2 border-gray-300 dark:border-gray-600 ml-2 flex flex-col space-y-2">

            @foreach(['daily', 'weekly', 'monthly', 'yearly', 'chart'] as $type)
                <button wire:click="$dispatch('getSongs:getReportType', { 'reportType' :'{{ $type }}'})"
                        aria-label="Select {{ ucfirst($type) }} Report"
                        class="flex items-center px-6 py-3
                    {{ $reportType == $type ? 'bg-red-500 dark:bg-red-400' : 'bg-blue-500 dark:bg-blue-600' }}
                    text-white font-medium rounded-md hover:bg-blue-400 dark:hover:bg-red-400 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-500 transition">
                    {{ ucfirst($type) }}
                </button>
            @endforeach

        </div>


        <livewire:last-fm.get-songs.list-chart :reportType="$reportType"/>
    </div>
</div>
