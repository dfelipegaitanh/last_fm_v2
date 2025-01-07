<button
        wire:click="toggleTheme"
        @click="
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light'); "
        x-init="
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        } "
        class="px-4 py-2 text-sm bg-white dark:bg-gray-800 rounded transition duration-300 hover:bg-gray-100
        dark:hover:bg-gray-700 hover:scale-105  hover:shadow-md hover:shadow-gray-300 dark:hover:shadow-gray-900
        focus:outline-none focus:ring-0 focus:ring-offset-0">
    <span class="sr-only">Toggle Dark/Light Mode</span>
    <span class="text-gray-800 dark:text-gray-300 transition-all duration-200 ease-in-out">
        {{ $isDark ? '☀️ Dark Mode' : '🌙 Light Mode' }}
    </span>

</button>
