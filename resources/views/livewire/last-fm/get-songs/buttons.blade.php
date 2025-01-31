<div class="flex w-1/5 flex-col space-y-4 border-r bg-gray-100 p-6">
    <button
        wire:click="$set('filter', 'daily')"
        class="{{ $filter == 'daily' ? 'bg-red-600' : 'bg-blue-500' }} flex items-center rounded-md px-6 py-3 font-medium text-white transition hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300"
    >
        Daily
    </button>

    <button
        wire:click="$set('filter', 'weekly')"
        class="{{ $filter == 'weekly' ? 'bg-red-600' : 'bg-blue-500' }} flex items-center rounded-md px-6 py-3 font-medium text-white transition hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300"
    >
        Weekly
    </button>

    <button
        wire:click="$set('filter', 'monthly')"
        class="{{ $filter == 'monthly' ? 'bg-red-600' : 'bg-blue-500' }} flex items-center rounded-md px-6 py-3 font-medium text-white transition hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300"
    >
        Monthly
    </button>

    <button
        wire:click="$set('filter', 'yearly')"
        class="{{ $filter == 'yearly' ? 'bg-red-600' : 'bg-blue-500' }} flex items-center rounded-md px-6 py-3 font-medium text-white transition hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300"
    >
        Yearly
    </button>

    <button
        wire:click="$set('filter', 'chart')"
        class="{{ $filter == 'chart' ? 'bg-red-600' : 'bg-blue-500' }} flex items-center rounded-md px-6 py-3 font-medium text-white transition hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300"
    >
        Chart
    </button>
</div>
