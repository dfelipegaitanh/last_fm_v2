<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=vt323:400&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes blink {
                0%,
                100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0;
                }
            }
            .cursor-blink::after {
                content: '_';
                animation: blink 1s step-end infinite;
            }
            .checkbox-dos:checked::after {
                content: 'X';
                position: absolute;
                color: #ff00ff; /* magenta */
                font-size: 1rem;
                top: -0.2rem;
                left: 0.2rem;
            }
        </style>
    </head>
    <body
        class="bg-[#000080] p-8 font-['VT323'] tracking-wider text-[#00FF00] antialiased dark:bg-[#000080] dark:text-[#00FF00]"
    >
        <div
            class="mx-auto max-w-2xl border-4 border-[#00FFFF] p-6 shadow-[8px_8px_0_rgba(0,0,0,0.5)] dark:border-[#00FFFF] dark:shadow-gray-950/50"
        >
            <div class="mb-8 border-b-2 border-[#00FFFF] pb-4 text-center dark:border-[#00FFFF]">
                <h1 class="mb-2 text-4xl uppercase text-[#FF00FF] dark:text-[#FF00FF]">C:\> LOGIN.EXE</h1>
                <p class="text-xl text-[#00FFFF] dark:text-[#00FFFF]">
                    {{ config('app.name', 'Laravel') }} Authentication System v1.0
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6">
                    <p class="text-[#FF00FF] dark:text-[#FF00FF]">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label class="mb-1 block text-xl text-[#00FFFF] dark:text-[#00FFFF]" for="email">
                        C:\> ENTER EMAIL:
                    </label>
                    <input
                        id="email"
                        class="cursor-blink mt-2 w-full border-2 border-[#00FF00] bg-black p-2 font-['VT323'] text-xl text-[#00FF00] focus:border-[#FF00FF] focus:shadow-[0_0_0_2px_#FF00FF] focus:outline-none dark:border-[#00FF00] dark:bg-black dark:text-[#00FF00] dark:focus:border-[#FF00FF] dark:focus:shadow-[0_0_0_2px_#FF00FF]"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                    />
                    @error('email')
                        <p class="mt-2 text-lg text-red-600 dark:text-red-500">ERROR: {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="mb-1 block text-xl text-[#00FFFF] dark:text-[#00FFFF]" for="password">
                        C:\> ENTER PASSWORD:
                    </label>
                    <input
                        id="password"
                        class="mt-2 w-full border-2 border-[#00FF00] bg-black p-2 font-['VT323'] text-xl text-[#00FF00] focus:border-[#FF00FF] focus:shadow-[0_0_0_2px_#FF00FF] focus:outline-none dark:border-[#00FF00] dark:bg-black dark:text-[#00FF00] dark:focus:border-[#FF00FF] dark:focus:shadow-[0_0_0_2px_#FF00FF]"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />
                    @error('password')
                        <p class="mt-2 text-lg text-red-600 dark:text-red-500">ERROR: {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center" for="remember_me">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="checkbox-dos relative h-5 w-5 cursor-pointer appearance-none border-2 border-[#00FF00] bg-black align-middle dark:border-[#00FF00] dark:bg-black"
                            name="remember"
                        />
                        <span class="ml-2">REMEMBER SESSION [Y/N]</span>
                    </label>
                </div>

                <div class="mt-8 flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a
                            class="text-lg text-[#FFFF00] no-underline hover:text-[#FF00FF] hover:underline dark:text-[#FFFF00] dark:hover:text-[#FF00FF]"
                            href="{{ route('password.request') }}"
                        >
                            FORGOT PASSWORD? [F1]
                        </a>
                    @endif

                    <button
                        type="submit"
                        class="border-2 border-[#00FF00] bg-[#FFA500] px-6 py-2 font-['VT323'] text-xl font-bold uppercase text-black shadow-[4px_4px_0_rgba(0,0,0,0.5)] transition-all duration-100 hover:translate-x-0.5 hover:translate-y-0.5 hover:bg-[#FF00FF] hover:shadow-[2px_2px_0_rgba(0,0,0,0.5)] dark:border-[#00FF00] dark:bg-[#FFA500] dark:text-black dark:hover:bg-[#FF00FF]"
                    >
                        EXECUTE LOGIN
                    </button>
                </div>

                <div class="mt-8 text-center text-[#00FFFF] dark:text-[#00FFFF]">
                    <p>PRESS [ESC] TO ABORT OR [ENTER] TO CONTINUE</p>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center text-sm text-[#00FF00] dark:text-[#00FF00]">
            <pre
                class="mx-auto mt-4 inline-block overflow-x-auto text-left font-['VT323'] text-xs text-[#FFFF00] dark:text-[#FFFF00] sm:text-sm md:text-base"
            >
       .-------------.             _____  _____ _     __  ____  _______
      /\_\_\_\_\_\_\_\_\_\_\       |  ___|| ____| |   | | |  _ \| ____|
     /\_\_\_\_\_\_\_\_\_\_\_\      | |_   |  _| | |   | | | |_) |  _|
    |\_\_\----. .----\_\_\|        |  _|  | |___| |___| | |  __/| |___
    |  (  o o )(  o o )  |         |_|    |_____|_____|_| |_|   |_____|
    |   \    /  \    /   |
    |    \--/    \--/    |
     \     ______      /
      \    \____/     /
       \    ^^      /
        \_________/
            </pre>
            <p>© {{ date('Y') }} {{ config('app.name', 'Laravel') }} - ALL RIGHTS RESERVED</p>
            <p>MEMORY AVAILABLE: 640K - DOS VERSION 6.22</p>
        </div>
    </body>
</html>
