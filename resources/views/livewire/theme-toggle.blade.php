<button
        wire:click="toggleTheme"
        @click="document.documentElement.classList.toggle('dark')"
        class="px-4 py-2 text-sm bg-white dark:bg-gray-800 rounded">
    {{ $isDark ? '☀️ Dark Mode' : '🌙 Light Mode' }}
</button>
