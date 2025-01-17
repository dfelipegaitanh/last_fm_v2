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
    <x-body>
        <livewire:layout.navigation/>

            <!-- Page Heading -->
        @if (isset($header))
            <x-header> {{ $header }}</x-header>
            @endif

            <!-- Page Content -->
        <main class="container mx-auto px-6 py-10 space-y-12">
            <div class="flex flex-col md:flex-row gap-12">
                <aside class="w-full md:w-1/4 p-6 home_container_base">
                    <div class="space-y-4">
                        <livewire:index.buttons/>
                    </div>
                </aside>

                <section class="flex-1 p-10 home_container_base">
                    {{ $slot }}
                </section>
            </div>
        </main>

    </x-body>
</html>
