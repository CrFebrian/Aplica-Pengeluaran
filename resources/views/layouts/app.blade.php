<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Catatuang') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-body-md antialiased bg-background text-on-background min-h-screen pb-32">

        <!-- TopAppBar -->
        <header class="w-full top-0 sticky z-40 bg-background flex items-center justify-between px-margin-mobile py-sm border-b-2 border-outline-variant">
            <button aria-label="Menu" class="text-primary active:translate-y-0.5 transition-transform">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <h1 class="font-display text-display-lg-mobile tracking-tighter text-primary">
                {{ strtoupper(config('app.name', 'Catatuang')) }}
            </h1>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" aria-label="Account" class="text-primary active:translate-y-0.5 transition-transform">
                    <span class="material-symbols-outlined">account_circle</span>
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak
                     class="absolute right-0 mt-xs w-48 bg-surface-container border-2 border-outline-variant neo-shadow z-50">
                    <a href="{{ route('profile') }}" wire:navigate class="block px-sm py-xs font-sans text-body-md text-on-surface hover:bg-surface-container-high transition-colors">
                        Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-sm py-xs font-sans text-body-md text-tertiary hover:bg-surface-container-high transition-colors">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Heading -->
        @if (isset($header))
            <div class="px-margin-mobile pt-md md:px-margin-desktop md:max-w-4xl md:mx-auto">
                {{ $header }}
            </div>
        @endif

        <!-- Main Content -->
        <main class="px-margin-mobile pt-md pb-xl md:px-margin-desktop md:max-w-4xl md:mx-auto grid gap-md">
            {{ $slot }}
        </main>

        <!-- Floating Action Button -->
        <button aria-label="Tambah Transaksi" class="fixed bottom-24 right-margin-mobile w-16 h-16 bg-primary-container text-white flex items-center justify-center border-2 border-outline-variant shadow-[6px_6px_0px_0px_#1e1b4b] active:shadow-[2px_2px_0px_0px_#1e1b4b] active:translate-y-1 active:translate-x-1 transition-all z-40 md:right-margin-desktop md:bottom-10">
            <span class="material-symbols-outlined" style="font-size: 32px;">add</span>
        </button>

        <!-- BottomNavBar -->
        <nav class="fixed bottom-0 w-full z-50 bg-surface border-t-2 border-outline-variant md:hidden">
            <div class="flex justify-around items-center h-xl px-gutter bg-surface">
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="flex flex-col items-center justify-center {{ request()->routeIs('dashboard') ? 'bg-secondary-container text-on-secondary-container border-2 border-on-surface shadow-[4px_4px_0px_0px_#000] -translate-x-0.5 -translate-y-0.5' : 'text-on-surface-variant opacity-80' }} w-16 h-12 transition-all duration-100">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-sans text-label-caps mt-1">Dashboard</span>
                </a>
                <a href="{{ Route::has('transactions.index') ? route('transactions.index') : '#' }}"
                   class="flex flex-col items-center justify-center text-on-surface-variant opacity-80 hover:bg-surface-container-highest w-16 h-12 transition-colors">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="font-sans text-label-caps mt-1">History</span>
                </a>
                <a href="{{ Route::has('debts.index') ? route('debts.index') : '#' }}"
                   class="flex flex-col items-center justify-center text-on-surface-variant opacity-80 hover:bg-surface-container-highest w-16 h-12 transition-colors">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                    <span class="font-sans text-label-caps mt-1">Debts</span>
                </a>
                <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}"
                   class="flex flex-col items-center justify-center text-on-surface-variant opacity-80 hover:bg-surface-container-highest w-16 h-12 transition-colors">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-sans text-label-caps mt-1">Settings</span>
                </a>
            </div>
        </nav>
    </body>
</html>
