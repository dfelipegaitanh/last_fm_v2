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
                0%, 100% { opacity: 1; }
                50% { opacity: 0; }
            }
            .cursor-blink::after {
                content: "_";
                animation: blink 1s step-end infinite;
            }
            .checkbox-dos:checked::after {
                content: "X";
                position: absolute;
                color: #ff00ff; /* magenta */
                font-size: 1rem;
                top: -0.2rem;
                left: 0.2rem;
            }
        </style>
    </head>
    <body class="font-['VT323'] tracking-wider text-[#00FF00] bg-[#000080] p-8 antialiased dark:text-[#00FF00] dark:bg-[#000080]">
        <div class="max-w-2xl mx-auto border-4 border-[#00FFFF] p-6 shadow-[8px_8px_0_rgba(0,0,0,0.5)] dark:border-[#00FFFF] dark:shadow-gray-950/50">
            <div class="text-center mb-8 border-b-2 border-[#00FFFF] pb-4 dark:border-[#00FFFF]">
                <h1 class="text-4xl text-[#FF00FF] uppercase mb-2 dark:text-[#FF00FF]">C:\> LOGIN.EXE</h1>
                <p class="text-xl text-[#00FFFF] dark:text-[#00FFFF]">{{ config('app.name', 'Laravel') }} Authentication System v1.0</p>
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
                    <label class="block text-xl text-[#00FFFF] mb-1 dark:text-[#00FFFF]" for="email">C:\> ENTER EMAIL:</label>
                    <input 
                        id="email"
                        class="w-full bg-black border-2 border-[#00FF00] text-[#00FF00] font-['VT323'] text-xl p-2 mt-2 focus:outline-none focus:border-[#FF00FF] focus:shadow-[0_0_0_2px_#FF00FF] cursor-blink dark:bg-black dark:border-[#00FF00] dark:text-[#00FF00] dark:focus:border-[#FF00FF] dark:focus:shadow-[0_0_0_2px_#FF00FF]"
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
                    <label class="block text-xl text-[#00FFFF] mb-1 dark:text-[#00FFFF]" for="password">C:\> ENTER PASSWORD:</label>
                    <input 
                        id="password"
                        class="w-full bg-black border-2 border-[#00FF00] text-[#00FF00] font-['VT323'] text-xl p-2 mt-2 focus:outline-none focus:border-[#FF00FF] focus:shadow-[0_0_0_2px_#FF00FF] dark:bg-black dark:border-[#00FF00] dark:text-[#00FF00] dark:focus:border-[#FF00FF] dark:focus:shadow-[0_0_0_2px_#FF00FF]"
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
                            class="appearance-none w-5 h-5 bg-black border-2 border-[#00FF00] relative align-middle cursor-pointer checkbox-dos dark:bg-black dark:border-[#00FF00]"
                            name="remember"
                        />
                        <span class="ml-2">REMEMBER SESSION [Y/N]</span>
                    </label>
                </div>
                
                <div class="flex justify-between items-center mt-8">
                    @if (Route::has('password.request'))
                        <a class="text-lg text-[#FFFF00] no-underline hover:underline hover:text-[#FF00FF] dark:text-[#FFFF00] dark:hover:text-[#FF00FF]" href="{{ route('password.request') }}">
                            FORGOT PASSWORD? [F1]
                        </a>
                    @endif
                    
                    <button type="submit" class="bg-[#FFA500] text-black font-['VT323'] text-xl font-bold py-2 px-6 border-2 border-[#00FF00] uppercase shadow-[4px_4px_0_rgba(0,0,0,0.5)] transition-all duration-100 hover:bg-[#FF00FF] hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-[2px_2px_0_rgba(0,0,0,0.5)] dark:bg-[#FFA500] dark:text-black dark:border-[#00FF00] dark:hover:bg-[#FF00FF]">
                        EXECUTE LOGIN
                    </button>
                </div>
                
                <div class="mt-8 text-center text-[#00FFFF] dark:text-[#00FFFF]">
                    <p>PRESS [ESC] TO ABORT OR [ENTER] TO CONTINUE</p>
                </div>
            </form>
        </div>
        
        <div class="text-center mt-8 text-sm text-[#00FF00] dark:text-[#00FF00]">
            <pre class="font-['VT323'] text-[#FFFF00] text-xs sm:text-sm md:text-base mt-4 mx-auto inline-block text-left overflow-x-auto dark:text-[#FFFF00]">
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
