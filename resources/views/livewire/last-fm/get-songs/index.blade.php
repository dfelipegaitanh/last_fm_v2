<div
    wire:loading.class="disabled-div"
    class="relative overflow-hidden rounded-xl border-x-2 border-gray-200 bg-white p-6 shadow-md dark:border-gray-700 dark:bg-gray-800"
>
    <div class="flex">
        @if (false)
            <livewire:last-fm.get-songs.buttons :filter="$reportType" />
        @endif

        <!-- Barra Lateral con Botones -->
        <div
            class="ml-2 flex w-1/5 flex-col space-y-2 rounded-xl border-2 border-gray-300 bg-gray-50 p-8 shadow-md dark:border-gray-600 dark:bg-gray-800"
        >
            @foreach (['daily', 'weekly', 'monthly', 'yearly', 'chart'] as $type)
                <button
                    wire:click="$dispatch('getSongs:getReportType', { 'reportType' :'{{ $type }}'})"
                    aria-label="Select {{ ucfirst($type) }} Report"
                    class="{{ $reportType == $type ? 'bg-red-500 dark:bg-red-400' : 'bg-blue-500 dark:bg-blue-600' }} flex items-center rounded-md px-6 py-3 font-medium text-white transition hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:hover:bg-red-400 dark:focus:ring-blue-500"
                >
                    {{ ucfirst($type) }}
                </button>
            @endforeach
        </div>

        <livewire:last-fm.get-songs.list-chart :reportType="$reportType" />
    </div>
</div>
