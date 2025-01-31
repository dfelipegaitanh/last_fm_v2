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
    <x-body>
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <x-header>{{ $header }}</x-header>
        @endif

        <!-- Page Content -->
        <x-main>
            <x-main.aside>
                <livewire:index.buttons />
            </x-main.aside>

            <x-main.section>
                {{ $slot }}
            </x-main.section>
        </x-main>
    </x-body>
</html>
