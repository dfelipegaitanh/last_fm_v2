<div wire:loading.class="disabled-div"
     class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 p-6 min-h-[150px]">

    <div class="inline-flex rounded-md shadow-sm">
        <button wire:click="$set('filter', 'daily')"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 border border-indigo-600 rounded-l-md hover:bg-indigo-400 focus:z-10 focus:ring-2 focus:ring-indigo-300">
            Daily
        </button>

        <button wire:click="$set('filter', 'weekly')"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 border-t border-b border-indigo-600 hover:bg-indigo-400 focus:z-10 focus:ring-2 focus:ring-indigo-300">
            Weekly
        </button>

        <button wire:click="$set('filter', 'monthly')"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 border-t border-b border-indigo-600 hover:bg-indigo-400 focus:z-10 focus:ring-2 focus:ring-indigo-300">
            Monthly
        </button>

        <button wire:click="$set('filter', 'yearly')"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 border-t border-b border-indigo-600 hover:bg-indigo-400 focus:z-10 focus:ring-2 focus:ring-indigo-300">
            Yearly
        </button>

        <button wire:click="$set('filter', 'chart')"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-blue-600 rounded-r-md hover:bg-blue-400 focus:z-10 focus:ring-2 focus:ring-blue-300">
            Chart
        </button>
    </div>

    <div class="flex space-x-4 justify-center">
        <button wire:click="$set('filter', 'daily')"
                class="px-6 py-3 bg-indigo-500 text-white font-medium rounded-md hover:bg-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-50 transition">
            Daily
        </button>

        <button wire:click="$set('filter', 'weekly')"
                class="px-6 py-3 bg-indigo-500 text-white font-medium rounded-md hover:bg-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-50 transition">
            Weekly
        </button>

        <button wire:click="$set('filter', 'monthly')"
                class="px-6 py-3 bg-indigo-500 text-white font-medium rounded-md hover:bg-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-50 transition">
            Monthly
        </button>

        <button wire:click="$set('filter', 'yearly')"
                class="px-6 py-3 bg-indigo-500 text-white font-medium rounded-md hover:bg-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-50 transition">
            Yearly
        </button>

        <button wire:click="$set('filter', 'chart')"
                class="px-6 py-3 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 transition">
            Chart
        </button>
    </div>


    <div class="flex justify-center items-center h-screen">
        <div wire:loading>
            <livewire:placeholder.spinner-body/>
        </div>
    </div>

</div>
