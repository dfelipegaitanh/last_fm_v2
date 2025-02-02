@props(['isDark' => false])

<button
    x-data="{ dark: {{ $isDark ? 'true' : 'false' }} }"
    @click="
        dark = !dark;
        document.documentElement.classList.toggle('dark', dark);
        const newTheme = dark ? 'dark' : 'light';
        localStorage.setItem('theme', newTheme);
        fetch('/toggle-theme', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ theme: newTheme })
        });
    "
    x-init="
        if (localStorage.getItem('theme') === 'dark') {
            dark = true
            document.documentElement.classList.add('dark')
        } else {
            dark = false
            document.documentElement.classList.remove('dark')
        }
    "
    class="rounded bg-white px-4 py-2 text-sm transition duration-300 hover:scale-105 hover:bg-gray-100 hover:shadow-md hover:shadow-gray-300 focus:outline-none focus:ring-0 focus:ring-offset-0 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:shadow-gray-900"
>
    <span class="sr-only">Toggle Dark/Light Mode</span>
    <span
        class="text-gray-800 transition-all duration-200 ease-in-out dark:text-gray-300"
        x-text="dark ? '☀️ Light Mode' : '🌙 Dark Mode'"
    ></span>
</button>
