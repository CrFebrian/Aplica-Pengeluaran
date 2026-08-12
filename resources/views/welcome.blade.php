<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Catatku') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-main text-black selection:bg-black selection:text-main">
        <div class="relative min-h-screen overflow-hidden">

            <!-- Grid dot background -->
            <div class="pointer-events-none absolute inset-0 opacity-[0.15]" style="background-image: radial-gradient(black 1px, transparent 1px); background-size: 24px 24px;"></div>

            <div class="relative mx-auto max-w-6xl px-6 py-8">

                <!-- Header -->
                <header class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-base border-2 border-border bg-black text-xl font-black text-main shadow-brutal-sm">
                            Rp
                        </div>
                        <span class="text-xl font-black tracking-tight">{{ config('app.name', 'Catatku') }}</span>
                    </div>

                    @if (Route::has('login'))
                        <livewire:welcome.navigation />
                    @endif
                </header>

                <!-- Hero -->
                <main class="mt-16 flex flex-col items-center text-center sm:mt-24">

                    <span class="inline-block rotate-[-2deg] rounded-base border-2 border-border bg-warning px-4 py-1.5 text-sm font-bold shadow-brutal-sm">
                        ✦ Simpel. Jujur. Tanpa Ribet.
                    </span>

                    <h1 class="mt-8 max-w-3xl text-5xl font-black leading-[1.05] tracking-tight sm:text-7xl">
                        Uangmu Kabur?<br>
                        <span class="relative inline-block">
                            <span class="relative z-10">Kita Tangkap.</span>
                            <span class="absolute inset-x-0 bottom-2 z-0 h-4 bg-black sm:bottom-3 sm:h-6"></span>
                        </span>
                    </h1>

                    <p class="mt-6 max-w-xl text-lg font-medium text-black/80 sm:text-xl">
                        Satu tempat buat catat pemasukan, pengeluaran, dan hutang.
                        Tanpa spreadsheet ribet, tanpa alasan lupa lagi.
                    </p>

                    <div class="mt-10 flex flex-col items-center gap-4 sm:flex-row">
                        <a
                            href="{{ Route::has('register') ? route('register') : route('login') }}"
                            class="w-full rounded-base border-2 border-border bg-black px-8 py-4 text-lg font-bold text-main shadow-brutal transition hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#000] sm:w-auto"
                        >
                            Mulai Catat Sekarang →
                        </a>
                        <a
                            href="{{ route('login') }}"
                            class="w-full rounded-base border-2 border-border bg-white px-8 py-4 text-lg font-bold text-black shadow-brutal transition hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#000] sm:w-auto"
                        >
                            Sudah Punya Akun
                        </a>
                    </div>

                    <p class="mt-6 text-sm font-semibold text-black/60">
                        Gratis. Tanpa kartu kredit. Langsung pakai hari ini.
                    </p>

                    <!-- Decorative cards -->
                    <div class="mt-20 grid w-full max-w-3xl grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="rotate-[-3deg] rounded-base border-2 border-border bg-income p-5 text-left shadow-brutal transition hover:rotate-0">
                            <p class="text-xs font-bold uppercase tracking-wide text-black/60">Pemasukan</p>
                            <p class="mt-1 text-2xl font-black">+Rp 4.500.000</p>
                            <p class="mt-1 text-sm font-semibold text-black/70">Gaji Bulanan</p>
                        </div>
                        <div class="rotate-[2deg] rounded-base border-2 border-border bg-expense p-5 text-left shadow-brutal transition hover:rotate-0 sm:mt-6">
                            <p class="text-xs font-bold uppercase tracking-wide text-black/60">Pengeluaran</p>
                            <p class="mt-1 text-2xl font-black">-Rp 35.000</p>
                            <p class="mt-1 text-sm font-semibold text-black/70">Makan Siang</p>
                        </div>
                        <div class="rotate-[-1deg] rounded-base border-2 border-border bg-warning p-5 text-left shadow-brutal transition hover:rotate-0">
                            <p class="text-xs font-bold uppercase tracking-wide text-black/60">Hutang</p>
                            <p class="mt-1 text-2xl font-black">Rp 200.000</p>
                            <p class="mt-1 text-sm font-semibold text-black/70">Belum Lunas</p>
                        </div>
                    </div>

                </main>

                <!-- Footer -->
                <footer class="mt-24 border-t-2 border-black/10 pt-8 text-center text-sm font-semibold text-black/50">
                    © {{ date('Y') }} {{ config('app.name', 'Catatku') }}. Dibuat buat kamu yang capek uangnya tidak jelas ke mana.
                </footer>

            </div>
        </div>
    </body>
</html>