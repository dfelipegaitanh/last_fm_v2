<div class="flex flex-col items-center justify-center py-8 text-center">
    <svg
        class="mb-4 h-16 w-16 text-gray-400 dark:text-gray-500"
        xmlns="http://www.w3.org/2000/svg"
        fill="{{ $fill ?? 'none' }}"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        @if (! empty($slot))
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="{{ $strokeWidth ?? 2 }}"
                d="{{ $slot }}"
            />
        @endif

        @if (! empty($paths))
            @foreach ($paths as $path)
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="{{ $strokeWidth ?? 2 }}"
                    d="{{ $path }}"
                />
            @endforeach
        @endif
    </svg>
    <div class="rounded-lg border-2 border-dashed border-gray-300 p-6 text-center dark:border-gray-600">
        <p class="text-gray-500 dark:text-gray-400">{{ $message }}</p>
    </div>
</div>
