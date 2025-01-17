<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="flex flex-col min-h-screen">
        <livewire:layout.navigation/>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
        <main class="container mx-auto px-6 py-10 space-y-12">
            <div class="flex flex-col md:flex-row gap-12">
                <!-- Sidebar -->
                <aside
                    class="w-full md:w-1/4 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-light-lg
                    dark:shadow-dark-lg transition hover:shadow-xl dark:hover:shadow-dark-lg">
                    <div class="space-y-4">
                        <livewire:index.buttons/>
                    </div>
                </aside>

                <!-- Main Content -->
                <section
                    class="flex-1 bg-white dark:bg-gray-800 p-10 rounded-xl shadow-light-lg
                    dark:shadow-dark-lg transition hover:shadow-xl dark:hover:shadow-dark-lg">
                    {{ $slot }}
                </section>
            </div>
        </main>


    </div>
    </body>
</html>
