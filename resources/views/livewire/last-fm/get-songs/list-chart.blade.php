<div
    class="ml-2 w-4/5 rounded-xl border-x-2 border-t-2 border-gray-200 bg-gray-50 p-8 shadow-md dark:border-gray-700 dark:bg-gray-800"
>
    <!-- Mensaje cuando no hay reportType -->
    <div
        class="{{ ! empty($reportType) ? 'max-h-0 opacity-0' : 'max-h-screen py-2 opacity-100' }} flex flex-col items-center justify-center overflow-hidden text-center transition-all duration-500 ease-out"
    >
        <livewire:last-fm.mesages.not-data-shown />
    </div>

    <!-- Switch para estados activos/inactivos -->

    @switch($buttons[$reportType])
        @case(\App\Enums\ButtonStateEnum::INACTIVE)
            <livewire:last-fm.mesages.report-not-available :reportType="$reportType" />

            @break
        @case(\App\Enums\ButtonStateEnum::ACTIVE)
            @livewire('last-fm.get-songs.reports.' . Str::lower($reportType))

            @break
    @endswitch

    <!-- Spinner mientras carga -->
    <div class="mt-4 flex items-center justify-center" aria-live="polite" role="status">
        <div wire:loading>
            <livewire:placeholder.spinner-body />
        </div>
    </div>
</div>
