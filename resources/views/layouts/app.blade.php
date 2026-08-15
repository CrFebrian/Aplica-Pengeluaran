<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KapanRich') }}</title>
        <x-theme-init />
        <x-favicon />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-body-md antialiased bg-background text-on-background min-h-screen md:flex" x-data="{ sidebarOpen: false }">
        <aside class="hidden md:flex md:w-64 md:shrink-0 md:flex-col md:h-screen md:sticky md:top-0 bg-surface-container border-r-2 border-outline-variant">

            <div class="flex items-center gap-2 p-md border-b-2 border-outline-variant">
                <x-app-logo size="h-8 w-8" fallback-class="text-sm" />
                <span class="font-display text-title-sm text-primary truncate flex-1">{{ strtoupper(config('app.name', 'KapanRich')) }}</span>
                <x-theme-toggle size="h-8 w-8" />
            </div>

            <nav class="flex flex-col gap-1 p-sm">
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="flex items-center gap-sm px-sm py-sm font-sans text-body-md font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary text-white border-2 border-outline-variant shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))]' : 'text-on-surface hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">dashboard</span> Dashboard
                </a>
                <a href="{{ Route::has('transactions.index') ? route('transactions.index') : '#' }}" wire:navigate
                   class="flex items-center gap-sm px-sm py-sm font-sans text-body-md font-semibold transition-colors {{ request()->routeIs('transactions.*') ? 'bg-primary text-white border-2 border-outline-variant shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))]' : 'text-on-surface hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">history</span> History
                </a>
                <a href="{{ Route::has('debts.index') ? route('debts.index') : '#' }}" wire:navigate
                   class="flex items-center gap-sm px-sm py-sm font-sans text-body-md font-semibold transition-colors {{ request()->routeIs('debts.*') ? 'bg-primary text-white border-2 border-outline-variant shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))]' : 'text-on-surface hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">account_balance_wallet</span> Debts
                </a>
                <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" wire:navigate
                   class="flex items-center gap-sm px-sm py-sm font-sans text-body-md font-semibold transition-colors {{ request()->routeIs('categories.*') ? 'bg-primary text-white border-2 border-outline-variant shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))]' : 'text-on-surface hover:bg-surface-container-high' }}">
                    <span class="material-symbols-outlined">settings</span> Categories
                </a>
            </nav>

            <div class="mt-auto flex flex-col gap-1 p-sm border-t-2 border-outline-variant">
                <a href="#"
                   class="flex items-center gap-sm px-sm py-sm font-sans text-body-md font-semibold text-on-surface hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined">help</span> Help
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-sm px-sm py-sm font-sans text-body-md font-semibold text-tertiary hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined">logout</span> Logout
                    </button>
                </form>

                <a href="{{ route('profile') }}" wire:navigate
                   class="mt-2 flex items-center gap-sm border-2 border-outline-variant bg-surface p-sm hover:bg-surface-container-high transition-colors">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center border-2 border-outline-variant bg-primary-container font-display text-sm font-black text-white">
                        {{ strtoupper(substr(auth()->user()->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex flex-col">
                        <span class="font-sans text-body-md font-bold text-on-surface truncate">{{ auth()->user()->name }}</span>
                        <span class="font-sans text-label-caps text-on-surface-variant truncate">{{ auth()->user()->email }}</span>
                    </div>
                </a>
            </div>
        </aside>
        <div class="flex-1 min-w-0 pb-32 md:pb-0">

            <!-- TopAppBar -->
            <header class="w-full top-0 sticky z-40 bg-background flex items-center justify-between px-margin-mobile py-sm border-b-2 border-outline-variant md:hidden">
                <button @click="sidebarOpen = true" aria-label="Menu" class="text-primary active:translate-y-0.5 transition-transform">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="flex items-center gap-2">
                    <x-app-logo size="h-6 w-6" fallback-class="text-xs" />
                    <h1 class="font-display text-display-lg-mobile tracking-tighter text-primary">
                        {{ strtoupper(config('app.name', 'KapanRich')) }}
                    </h1>
                </div>
                <div class="flex items-center gap-3">
                    {{-- NEW: Dark/Light mode toggle --}}
                    <x-theme-toggle size="h-8 w-8" flat />

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
                </div>
                </div>
            </header>

            <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-[70] md:hidden">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="sidebarOpen = false"></div>

                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="relative w-72 max-w-[80%] h-full bg-surface-container border-r-2 border-outline-variant flex flex-col">

                    <div class="flex items-center justify-between p-md border-b-2 border-outline-variant">
                        <div class="flex items-center gap-2">
                            <x-app-logo size="h-7 w-7" fallback-class="text-xs" />
                            <span class="font-display text-title-sm text-primary">{{ strtoupper(config('app.name', 'KapanRich')) }}</span>
                        </div>
                        <button @click="sidebarOpen = false" aria-label="Tutup menu" class="text-on-surface-variant hover:text-on-surface transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <nav class="flex flex-col p-sm gap-1">
                        <a href="{{ route('dashboard') }}" wire:navigate @click="sidebarOpen = false"
                           class="flex items-center gap-sm px-sm py-sm font-sans text-body-md {{ request()->routeIs('dashboard') ? 'bg-primary-container text-white' : 'text-on-surface hover:bg-surface-container-high' }} transition-colors">
                            <span class="material-symbols-outlined">dashboard</span> Dashboard
                        </a>
                        <a href="{{ Route::has('transactions.index') ? route('transactions.index') : '#' }}" wire:navigate @click="sidebarOpen = false"
                           class="flex items-center gap-sm px-sm py-sm font-sans text-body-md {{ request()->routeIs('transactions.*') ? 'bg-primary-container text-white' : 'text-on-surface hover:bg-surface-container-high' }} transition-colors">
                            <span class="material-symbols-outlined">receipt_long</span> Riwayat Transaksi
                        </a>
                        <a href="{{ Route::has('debts.index') ? route('debts.index') : '#' }}" wire:navigate @click="sidebarOpen = false"
                           class="flex items-center gap-sm px-sm py-sm font-sans text-body-md {{ request()->routeIs('debts.*') ? 'bg-primary-container text-white' : 'text-on-surface hover:bg-surface-container-high' }} transition-colors">
                            <span class="material-symbols-outlined">account_balance_wallet</span> Hutang
                        </a>
                        <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" wire:navigate @click="sidebarOpen = false"
                           class="flex items-center gap-sm px-sm py-sm font-sans text-body-md {{ request()->routeIs('categories.*') ? 'bg-primary-container text-white' : 'text-on-surface hover:bg-surface-container-high' }} transition-colors">
                            <span class="material-symbols-outlined">settings</span> Kategori
                        </a>
                    </nav>

                    <form method="POST" action="{{ route('logout') }}" class="mt-auto p-sm border-t-2 border-outline-variant">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-sm px-sm py-sm font-sans text-body-md text-tertiary hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined">logout</span> Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <div class="px-margin-mobile pt-md md:px-margin-desktop md:max-w-4xl">
                    {{ $header }}
                </div>
            @endif

            <!-- Main Content -->
            <main class="px-margin-mobile pt-md pb-xl md:px-margin-desktop md:max-w-4xl grid gap-md">
                {{ $slot }}
            </main>
        </div>

        @if (request()->routeIs('debts.*'))
            <button @click="$dispatch('open-debt-form')" aria-label="Catat Hutang" class="fixed bottom-24 right-margin-mobile w-16 h-16 bg-warning text-on-warning flex items-center justify-center border-2 border-outline-variant shadow-[6px_6px_0px_0px_#78350f] active:shadow-[2px_2px_0px_0px_#78350f] active:translate-y-1 active:translate-x-1 transition-all z-40 md:right-margin-desktop md:bottom-10">
                <span class="material-symbols-outlined" style="font-size: 32px;">add</span>
            </button>
        @else
            <button @click="$dispatch('open-transaction-form')" aria-label="Tambah Transaksi" class="fixed bottom-24 right-margin-mobile w-16 h-16 bg-primary-container text-white flex items-center justify-center border-2 border-outline-variant shadow-[6px_6px_0px_0px_#1e1b4b] active:shadow-[2px_2px_0px_0px_#1e1b4b] active:translate-y-1 active:translate-x-1 transition-all z-40 md:right-margin-desktop md:bottom-10">
                <span class="material-symbols-outlined" style="font-size: 32px;">add</span>
            </button>
        @endif
        
        <nav class="fixed bottom-0 w-full z-50 bg-surface border-t-2 border-outline-variant md:hidden">
            <div class="flex justify-around items-center h-xl px-gutter bg-surface">
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="flex flex-col items-center justify-center {{ request()->routeIs('dashboard') ? 'bg-secondary-container text-on-secondary-container border-2 border-on-surface shadow-[4px_4px_0px_0px_#000] -translate-x-0.5 -translate-y-0.5' : 'text-on-surface-variant opacity-80' }} w-16 h-12 transition-all duration-100">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-sans text-label-caps mt-1">Dashboard</span>
                </a>
                <a href="{{ Route::has('transactions.index') ? route('transactions.index') : '#' }}" wire:navigate
                   class="flex flex-col items-center justify-center {{ request()->routeIs('transactions.*') ? 'bg-secondary-container text-on-secondary-container border-2 border-on-surface shadow-[4px_4px_0px_0px_#000] -translate-x-0.5 -translate-y-0.5' : 'text-on-surface-variant opacity-80' }} w-16 h-12 transition-all duration-100">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="font-sans text-label-caps mt-1">History</span>
                </a>
                <a href="{{ Route::has('debts.index') ? route('debts.index') : '#' }}" wire:navigate
                   class="flex flex-col items-center justify-center {{ request()->routeIs('debts.*') ? 'bg-secondary-container text-on-secondary-container border-2 border-on-surface shadow-[4px_4px_0px_0px_#000] -translate-x-0.5 -translate-y-0.5' : 'text-on-surface-variant opacity-80' }} w-16 h-12 transition-all duration-100">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                    <span class="font-sans text-label-caps mt-1">Debts</span>
                </a>
                <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" wire:navigate
                   class="flex flex-col items-center justify-center {{ request()->routeIs('categories.*') ? 'bg-secondary-container text-on-secondary-container border-2 border-on-surface shadow-[4px_4px_0px_0px_#000] -translate-x-0.5 -translate-y-0.5' : 'text-on-surface-variant opacity-80' }} w-16 h-12 transition-all duration-100">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-sans text-label-caps mt-1">Settings</span>
                </a>
            </div>
        </nav>

        <!-- Transaction Form Modal -->
        <livewire:transactions.transaction-form />
    </body>
</html>