@php
    $activeIndex = match (true) {
        request()->routeIs('dashboard') => 0,
        request()->routeIs('transactions.*') => 1,
        request()->routeIs('debts.*') => 2,
        request()->routeIs('categories.*') => 3,
        default => 0,
    };
@endphp

<nav class="fixed bottom-0 left-0 right-0 z-50 md:hidden px-4 pb-[calc(env(safe-area-inset-bottom)+1rem)]">
    <div class="relative flex items-center bg-primary border-2 border-outline-variant rounded-full p-2 shadow-[0_8px_0_0_rgb(var(--color-shadow-ink))] w-full max-w-md mx-auto">

        {{-- Indikator geser: lebar & posisinya dihitung relatif (%) terhadap pill, bukan piksel tetap,
             jadi tetap pas di HP ukuran berapa pun --}}
        <div
            class="absolute top-2 bottom-2 left-2 rounded-full bg-white shadow-sm transition-transform duration-300 ease-out"
            style="width: calc((100% - 1rem) / 4); transform: translateX(calc({{ $activeIndex }} * 100%));"
        ></div>

        <a href="{{ route('dashboard') }}" wire:navigate
           class="relative z-10 flex-1 flex items-center justify-center h-12 transition-colors duration-300 {{ $activeIndex === 0 ? 'text-primary' : 'text-white/70 hover:text-white' }}">
            <span class="material-symbols-outlined">dashboard</span>
        </a>

        <a href="{{ Route::has('transactions.index') ? route('transactions.index') : '#' }}" wire:navigate
           class="relative z-10 flex-1 flex items-center justify-center h-12 transition-colors duration-300 {{ $activeIndex === 1 ? 'text-primary' : 'text-white/70 hover:text-white' }}">
            <span class="material-symbols-outlined">receipt_long</span>
        </a>

        <a href="{{ Route::has('debts.index') ? route('debts.index') : '#' }}" wire:navigate
           class="relative z-10 flex-1 flex items-center justify-center h-12 transition-colors duration-300 {{ $activeIndex === 2 ? 'text-primary' : 'text-white/70 hover:text-white' }}">
            <span class="material-symbols-outlined">account_balance_wallet</span>
        </a>

        <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" wire:navigate
           class="relative z-10 flex-1 flex items-center justify-center h-12 transition-colors duration-300 {{ $activeIndex === 3 ? 'text-primary' : 'text-white/70 hover:text-white' }}">
            <span class="material-symbols-outlined">settings</span>
        </a>
    </div>
</nav>