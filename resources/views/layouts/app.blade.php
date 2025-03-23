<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        class="font-sans antialiased selection:bg-indigo-500/10 selection:text-indigo-500 dark:selection:bg-indigo-400/10 dark:selection:text-indigo-400"
    >
        <div class="min-h-screen bg-white dark:bg-gray-950">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header
                    class="border-b border-gray-100 bg-white/80 backdrop-blur-sm dark:border-gray-800/50 dark:bg-gray-900/80"
                >
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        <h2 class="text-xl font-medium tracking-tight text-gray-800 dark:text-gray-200">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-12">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        class="overflow-hidden rounded-2xl border border-gray-200/50 bg-white/50 shadow-xl shadow-gray-200/50 ring-1 ring-gray-200/50 backdrop-blur-xl dark:border-gray-800/50 dark:bg-gray-900/50 dark:shadow-gray-950/50 dark:ring-gray-800/50"
                    >
                        <div class="p-8 text-gray-900 dark:text-gray-100">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>

    @isset($script)
        {{ $script }}
    @endisset
</html>
