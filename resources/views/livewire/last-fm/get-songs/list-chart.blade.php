<div class="w-4/5 bg-gray-50 dark:bg-gray-800 shadow-md p-8 rounded-xl border-x-2 border-t-2 border-gray-200 dark:border-gray-700 ml-2">

    <!-- Mensaje cuando no hay reportType -->
    <div class="flex flex-col items-center justify-center text-center transition-all duration-500 ease-out overflow-hidden
        {{ !empty($reportType) ? 'max-h-0 opacity-0' : 'max-h-screen opacity-100 py-2' }}">
        <livewire:last-fm.mesages.not-data-shown/>
    </div>

    <!-- Switch para estados activos/inactivos -->
    @switch($buttons[$reportType] )
        @case(\App\Enums\ButtonStateEnum::INACTIVE)
            <livewire:last-fm.mesages.report-not-available :reportType="$reportType"/>
            @break
        @case(\App\Enums\ButtonStateEnum::ACTIVE)
            @livewire('last-fm.get-songs.reports.' . Str::lower($reportType))
            @break
    @endswitch

    <!-- Spinner mientras carga -->
    <div class="flex justify-center items-center mt-4" aria-live="polite" role="status">
        <div wire:loading>
            <livewire:placeholder.spinner-body/>
        </div>
    </div>

</div>
