<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=abeezee:400|montserrat:700" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Scripts -->
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-[#0a0a0a] font-mono text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header wire:ignore class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        <nav class="flex items-center justify-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="inline-block px-5 py-1.5 text-[#EDEDEC] border border-[#3E3E3A] hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Dashboard
                </a>
            @else
                <a href="{{ url('/dashboard/login') }}"
                    class="inline-block px-5 py-1.5 text-[#EDEDEC] border border-transparent hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                    Log in
                </a>


                <a href="{{ url('/dashboard/register') }}"
                    class="inline-block px-5 py-1.5 text-[#EDEDEC] border border-[#3E3E3A] hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Register
                </a>

            @endauth
        </nav>
    </header>
    <div
        class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row-reverse">
            <div
                class="bg-gray-600 flex flex-col justify-around items-center lg:-ms-px -mb-px lg:mb-0 rounded-b-lg lg:rounded-bl-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                @livewire('package-tracking')
            </div>
            <div wire:ignore.self
                class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-20 bg-[#161615] text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-t-lg lg:rounded-l-lg lg:rounded-tr-none">
                <h1 class="mb-1 font-medium">Package Tracking System</h1>
                <p class="mb-2 text-[#A1A09A]">Lorem ipsum dolor sit amet consectetur.<br>
                    Lorem ipsum dolor sit amet consectetur.</p>
                <ul class="flex flex-col mb-4 lg:mb-6">
                    <li
                        class="flex items-center gap-4 py-2 relative before:border-l before:border-[#3E3E3A] before:top-1/2 before:bottom-0 before:left-[0.4rem] before:absolute">
                        <span class="relative py-1 bg-[#161615]">
                            <span
                                class="flex items-center justify-center rounded-full bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border border-[#3E3E3A]">
                                <span class="rounded-full bg-[#3E3E3A] w-1.5 h-1.5"></span>
                            </span>
                        </span>
                        <span>
                            Enter
                            <span
                                class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#FF4433] ms-1">Tracking
                                Code</span>
                        </span>
                    </li>
                    <li
                        class="flex items-center gap-4 py-2 relative before:border-l before:border-[#3E3E3A] before:bottom-1/2 before:top-0 before:start-[0.4rem] before:absolute">
                        <span class="relative py-1 bg-[#161615]">
                            <span
                                class="flex items-center justify-center rounded-full bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] w-3.5 h-3.5 border border-[#3E3E3A]">
                                <span class="rounded-full bg-[#3E3E3A] w-1.5 h-1.5"></span>
                            </span>
                        </span>
                        <span>
                            Track
                            <span
                                class="inline-flex items-center space-x-1 font-medium underline underline-offset-4 text-[#FF4433] ms-1">Your
                                Package</span>
                        </span>
                    </li>
                </ul>
                <ul class="flex gap-3 text-sm leading-normal">
                    @livewire('track-package')
                </ul>
            </div>
        </main>
    </div>
    @filamentScripts
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('update-url', (data) => {
                // Change URL without reload
                history.pushState(null, null, data.url);
            });
        });
    </script>
</body>

</html>
