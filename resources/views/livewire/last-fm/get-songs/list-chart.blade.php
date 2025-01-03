<div class="w-4/5 bg-gray-50 p-8">

    <div class="flex flex-col items-center justify-center text-center transition-all duration-500 ease-in-out overflow-hidden
        {{ !empty($reportType) ? 'max-h-0 opacity-0' : 'max-h-screen opacity-100 py-2' }}">
        <livewire:last-fm.mesages.not-data-shown/>

    </div>

    @switch($buttons[$reportType] )
        @case(\App\ButtonStateEnum::INACTIVE)
            <livewire:last-fm.mesages.report-not-available :reportType="$reportType"/>
            @break
        @case(\App\ButtonStateEnum::ACTIVE)
            {{ $reportType }}
            @break
    @endswitch


    @if(false)
    <div wire:loading.remove
         class="w-full bg-white shadow-md rounded-lg overflow-hidden border-4 border-transparent hover:border-blue-500 transition-all p-6
         {{ empty($reportType) ? ' hidden' : '' }}">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">
            {{ ucfirst($reportType) }} Songs Chart {{ $buttons[$reportType] }}
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full table-auto transition-opacity duration-500 ease-in-out"
                   wire:loading.class="opacity-50">
                <thead class="bg-gray-100 border-b-2 border-gray-300">
                <tr>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">#</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Song</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Artist</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Album</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Date</th>
                    <th class="py-3 px-4 text-left text-gray-600 font-medium">Plays</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-4">1</td>
                    <td class="py-4 px-4">Blinding Lights</td>
                    <td class="py-4 px-4">The Weeknd</td>
                    <td class="py-4 px-4">After Hours</td>
                    <td class="py-4 px-4">2025-01-01</td>
                    <td class="py-4 px-4">542</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
    @endif

    <div class="flex justify-center items-center">
        <div wire:loading>
            <livewire:placeholder.spinner-body/>
        </div>
    </div>

</div>
