<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <x-theme-init />
        <title>{{ config('app.name', 'KapanRich') }} — Duitmu, Kelakuanmu, Kelolamu</title>
        <x-favicon />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @keyframes float-slow {
                0%, 100% { transform: translateY(0) rotate(-2deg); }
                50% { transform: translateY(-14px) rotate(1deg); }
            }
            @keyframes wiggle {
                0%, 100% { transform: rotate(-3deg); }
                50% { transform: rotate(3deg); }
            }
            @keyframes pop-in {
                0% { opacity: 0; transform: translateY(24px) scale(0.95); }
                100% { opacity: 1; transform: translateY(0) scale(1); }
            }
            @keyframes blink {
                0%, 90%, 100% { transform: scaleY(1); }
                95% { transform: scaleY(0.1); }
            }
            .anim-float { animation: float-slow 5s ease-in-out infinite; }
            .anim-wiggle:hover { animation: wiggle 0.4s ease-in-out; }
            .anim-pop-in { animation: pop-in 0.6s cubic-bezier(0.16, 1, 0.3, 1) backwards; }
            .anim-blink { animation: blink 4s ease-in-out infinite; transform-origin: center; }
        </style>
    </head>
    <body class="antialiased font-sans bg-background text-on-background selection:bg-indigo-500 selection:text-white" x-data>
        <div class="relative min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-0 opacity-[0.2] dark:opacity-[0.2] text-black dark:text-white transition-colors duration-300" style="background-image: radial-gradient(currentColor 1px, transparent 1px); background-size: 24px 24px;"></div>
            <div class="relative mx-auto max-w-7xl px-6 py-6">

                <!-- Header -->
                <header class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-app-logo size="h-10 w-10" fallback-class="border-black dark:border-outline-variant text-lg shadow-[3px_3px_0px_0px_#000] dark:shadow-[3px_3px_0px_0px_#3f3f46] bg-indigo-500" />
                        <span class="font-display text-xl font-black tracking-tight">{{ strtoupper(config('app.name', 'KapanRich')) }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <x-theme-toggle />
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </div>
                </header>

                <!-- Hero -->
                <main class="mt-12 grid grid-cols-1 items-center gap-12 lg:mt-20 lg:grid-cols-2 lg:gap-8">
                    <div class="flex flex-col items-center text-center lg:items-start lg:text-left">
                        <span class="anim-float inline-block rotate-[-2deg] border-2 border-black dark:border-outline-variant bg-amber-400 px-4 py-1.5 font-display text-sm font-bold shadow-[3px_3px_0px_0px_#000] dark:shadow-[3px_3px_0px_0px_#3f3f46]">
                            ✦ NO CAP, INI BENERAN GRATIS
                        </span>

                        <h1 class="anim-pop-in mt-6 max-w-xl font-display text-5xl font-black leading-[1.05] tracking-tight sm:text-6xl lg:text-6xl" style="animation-delay: 0.1s">
                            Gajian Numpang<br>
                            <span class="relative inline-block">
                                <span class="relative z-10">Lewat?</span>
                                <span class="absolute inset-x-0 bottom-1 z-0 h-4 bg-rose-400 sm:bottom-2 sm:h-5"></span>
                            </span>
                            <br>
                            <span class="text-indigo-500 dark:text-primary">Udahan, Bro.</span>
                        </h1>

                        <p class="anim-pop-in mt-6 max-w-md font-sans text-lg font-medium text-black/70 dark:text-on-surface-variant" style="animation-delay: 0.2s">
                            Catat cuan masuk, war diskon, sampe utang temen yang belum balikin semua di satu tempat. Ga usah pake Excel jadul, cukup buka HP.
                        </p>

                        <div class="anim-pop-in mt-8 flex w-full flex-col items-center gap-4 sm:w-auto sm:flex-row lg:items-start" style="animation-delay: 0.3s">
                            <a
                                href="{{ Route::has('register') ? route('register') : route('login') }}"
                                class="w-full border-2 border-black dark:border-outline-variant bg-indigo-500 px-8 py-4 text-center font-display text-lg font-bold text-white shadow-[6px_6px_0px_0px_#000] dark:shadow-[6px_6px_0px_0px_#3f3f46] transition-all hover:-translate-y-1 hover:shadow-[8px_8px_0px_0px_#000] active:translate-y-0 active:translate-x-0 active:shadow-[2px_2px_0px_0px_#000] sm:w-auto"
                            >
                                Gaskeun, Daftar →
                            </a>
                            <a
                                href="{{ route('login') }}"
                                class="w-full border-2 border-black dark:border-outline-variant bg-white dark:bg-surface-container px-8 py-4 text-center font-display text-lg font-bold text-black dark:text-on-surface shadow-[6px_6px_0px_0px_#000] dark:shadow-[6px_6px_0px_0px_#3f3f46] transition-all hover:-translate-y-1 hover:shadow-[8px_8px_0px_0px_#000] active:translate-y-0 active:translate-x-0 active:shadow-[2px_2px_0px_0px_#000] sm:w-auto"
                            >
                                Udah Punya Akun
                            </a>
                        </div>
                    </div>

                    <!-- Right: Illustration -->
                    <div class="relative flex items-center justify-center">
                        <div class="anim-float relative w-full max-w-sm">
                            {{-- Ilustrasi vector flat: orang pegang HP, gaya neobrutalism --}}
                            <svg viewBox="0 0 400 460" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto overflow-visible">
                                <!-- Shadow blob dasar -->
                                <ellipse cx="200" cy="430" rx="120" ry="18" class="fill-black/10 dark:fill-black/40" />
                                <rect x="40" y="30" width="320" height="320" rx="4" class="fill-amber-300 dark:fill-primary-container" stroke="black" stroke-width="4" transform="rotate(-4 200 190)" />
                                <path d="M140 120 Q140 60 200 58 Q260 60 260 120 L260 190 L140 190 Z" fill="#1f1f22" stroke="black" stroke-width="4"/>
                                <path d="M110 460 L110 330 Q110 270 200 268 Q290 270 290 330 L290 460 Z" class="fill-indigo-500 dark:fill-primary" stroke="black" stroke-width="4"/>
                                <circle cx="200" cy="165" r="62" class="fill-[#ffcfa8]" stroke="black" stroke-width="4"/>
                                <path d="M138 150 Q140 96 200 92 Q260 96 262 150 Q230 118 200 118 Q170 118 138 150 Z" fill="#1f1f22" stroke="black" stroke-width="4"/>
                                <!-- Mata (kedip) -->
                                <g class="anim-blink">
                                    <rect x="172" y="162" width="10" height="14" rx="2" fill="black"/>
                                    <rect x="220" y="162" width="10" height="14" rx="2" fill="black"/>
                                </g>

                                <path d="M180 195 Q200 210 220 195" stroke="black" stroke-width="4" fill="none" stroke-linecap="round"/>
                                <circle cx="165" cy="185" r="8" class="fill-rose-300/70"/>
                                <circle cx="235" cy="185" r="8" class="fill-rose-300/70"/>

                                <path d="M150 340 Q90 330 85 260 Q83 230 110 225 Q130 222 135 250 Q138 290 175 310 Z" class="fill-indigo-500 dark:fill-primary" stroke="black" stroke-width="4"/>
                                <g transform="rotate(-8 100 245)">
                                    <rect x="65" y="185" width="70" height="120" rx="4" class="fill-[#131316] dark:fill-surface" stroke="black" stroke-width="4"/>
                                    <rect x="73" y="196" width="54" height="86" rx="2" class="fill-emerald-400 dark:fill-secondary"/>
                                    <rect x="82" y="210" width="36" height="8" rx="1" fill="black" opacity="0.6"/>
                                    <rect x="82" y="224" width="24" height="6" rx="1" fill="black" opacity="0.4"/>
                                    <circle cx="100" cy="296" r="3" fill="black" opacity="0.6"/>
                                </g>

                                <path d="M250 340 Q310 335 320 280 Q324 255 300 250 Q282 247 278 270 Q272 300 235 315 Z" class="fill-indigo-500 dark:fill-primary" stroke="black" stroke-width="4"/>

                                <!-- Koin melayang (dekorasi) -->
                                <g class="anim-wiggle" style="transform-origin: 340px 100px;">
                                    <circle cx="340" cy="100" r="26" class="fill-emerald-400 dark:fill-secondary" stroke="black" stroke-width="4"/>
                                    <text x="340" y="108" text-anchor="middle" font-family="Montserrat" font-weight="900" font-size="24" fill="black">Rp</text>
                                </g>

                                <!-- Bintang dekorasi -->
                                <path class="anim-wiggle fill-rose-400" style="transform-origin: 60px 90px;" d="M60 70 L67 85 L83 85 L70 95 L75 112 L60 102 L45 112 L50 95 L37 85 L53 85 Z" stroke="black" stroke-width="3"/>
                            </svg>
                        </div>
                    </div>
                </main>

                <!-- Decorative cards -->
                <div class="mt-24 mb-24 grid w-full grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="anim-pop-in anim-wiggle rotate-[-3deg] border-2 border-black dark:border-outline-variant bg-emerald-300 dark:bg-secondary p-5 text-left shadow-[6px_6px_0px_0px_#000] dark:shadow-[6px_6px_0px_0px_#3f3f46] transition-transform hover:rotate-0" style="animation-delay: 0.5s">
                        <p class="font-sans text-xs font-bold uppercase tracking-wide text-black/60">Cuan Masuk</p>
                        <p class="mt-1 font-display text-2xl font-black text-black">+Rp 4.500.000</p>
                        <p class="mt-1 font-sans text-sm font-semibold text-black/70">Gajian Bulanan</p>
                    </div>
                    <div class="anim-pop-in anim-wiggle rotate-[2deg] border-2 border-black dark:border-outline-variant bg-rose-300 dark:bg-tertiary p-5 text-left shadow-[6px_6px_0px_0px_#000] dark:shadow-[6px_6px_0px_0px_#3f3f46] transition-transform hover:rotate-0 sm:mt-6" style="animation-delay: 0.6s">
                        <p class="font-sans text-xs font-bold uppercase tracking-wide text-black/60">Jajan Abis</p>
                        <p class="mt-1 font-display text-2xl font-black text-black">-Rp 35.000</p>
                        <p class="mt-1 font-sans text-sm font-semibold text-black/70">Kopi Kekinian</p>
                    </div>
                    <div class="anim-pop-in anim-wiggle rotate-[-1deg] border-2 border-black dark:border-outline-variant bg-amber-300 dark:bg-warning p-5 text-left shadow-[6px_6px_0px_0px_#000] dark:shadow-[6px_6px_0px_0px_#3f3f46] transition-transform hover:rotate-0" style="animation-delay: 0.7s">
                        <p class="font-sans text-xs font-bold uppercase tracking-wide text-black/60">Utang Nunggak</p>
                        <p class="mt-1 font-display text-2xl font-black text-black">Rp 200.000</p>
                        <p class="mt-1 font-sans text-sm font-semibold text-black/70">Si Budi Belum Bayar</p>
                    </div>
                </div>
            </div>

            <!-- Footer dipindah ke luar max-w-7xl -->
             <footer class="relative z-10 w-full border-t-2 border-black/10 dark:border-outline-variant bg-[#f4f3ee] dark:bg-background px-6 py-8 text-center font-sans text-sm font-medium text-black/50 dark:text-on-surface-variant/60 transition-colors duration-300">
                © {{ date('Y') }} {{ strtoupper(config('app.name', 'KapanRich')) }}. Buat lo yang capek gatau duit lari ke mana.
            </footer>
        </div> 
</html>