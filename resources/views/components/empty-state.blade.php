<div class="flex flex-col items-center justify-center text-center py-8">
    <svg class="w-16 h-16 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="{{ $slot }}"></path>
    </svg>
    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
        <p class="text-gray-500">{{ $message ?? 'information is not available yet.' }}</p>
    </div>
</div>
