<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-theme-init />
        <title>{{ config('app.name', 'KapanRich') }}</title>
        <x-favicon />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-background text-on-background selection:bg-inverse-primary selection:text-surface" x-data>
        <div class="min-h-screen flex flex-col md:flex-row">

            <!-- Left Panel: Brand (hidden on mobile) -->
            <div class="hidden md:flex md:w-1/2 lg:w-3/5 bg-surface-container relative border-r-2 border-outline-variant overflow-hidden">
                <div class="absolute inset-0 opacity-[0.06] pointer-events-none text-on-surface" style="background-image: linear-gradient(currentColor 1px, transparent 1px), linear-gradient(90deg, currentColor 1px, transparent 1px); background-size: 32px 32px;"></div>
                <div class="relative z-10 p-xl flex flex-col justify-end w-full">
                    <div class="inline-flex bg-secondary-container text-on-secondary-container px-sm py-xs border-2 border-on-secondary-container neo-shadow w-max mb-md rotate-[-2deg]">
                        <span class="font-sans text-label-caps font-bold uppercase tracking-wide">Catatanmu, Kendalimu</span>
                    </div>
                    <h2 class="font-display text-display-lg text-on-background max-w-[12ch] leading-tight">
                        KUASAI ARUS UANGMU.
                    </h2>
                </div>
            </div>

            <!-- Right Panel: Auth Form Canvas -->
            <div class="flex-1 flex flex-col justify-center px-margin-mobile py-lg md:px-margin-desktop bg-background relative">
                <div class="absolute inset-0 opacity-[0.05] pointer-events-none text-on-surface" style="background-image: linear-gradient(currentColor 1px, transparent 1px), linear-gradient(90deg, currentColor 1px, transparent 1px); background-size: 32px 32px;"></div>
                <div class="absolute top-sm right-margin-mobile md:right-margin-desktop z-20">
                    <x-theme-toggle size="h-10 w-10" />
                </div>
                <div class="w-full max-w-[420px] mx-auto relative z-10">
                    <div class="mb-xl flex flex-col items-center gap-sm text-center md:flex-row md:items-center md:gap-3 md:text-left">
                        <a href="{{ url('/') }}" wire:navigate class="inline-block shrink-0 transition-transform hover:-translate-y-0.5 active:translate-y-0">
                            <x-app-logo size="h-12 w-12" fallback-class="text-xl" />
                        </a>
                        <h1 class="font-display text-display-lg-mobile md:text-display-lg text-on-background uppercase tracking-tighter">
                            {{ config('app.name', 'KapanRich') }}
                        </h1>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>