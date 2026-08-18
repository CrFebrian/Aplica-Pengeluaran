<div class="flex flex-col gap-md">
    <div class="flex flex-col mb-1 sm:mb-2">
        <h2 class="font-display text-2xl sm:text-headline-md font-bold text-on-surface uppercase">DAFTAR TRANSAKSI</h2>
        <p class="font-sans text-base sm:text-lg text-on-surface-variant mt-1">Jejak cuan dan pengeluaran lo nih. Pantau terus biar dompet tetap slay dan nggak mendadak boncos ya, bre!</p>
    </div>

    <div class="grid grid-cols-2 gap-sm sm:flex sm:flex-wrap">
        <button wire:click="setFilter('today')"
            class="snap-start shrink-0 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'today' ? 'bg-secondary-container text-on-secondary-container shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' }}">
            HARI INI
        </button>
        <button wire:click="setFilter('week')"
            class="snap-start shrink-0 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'week' ? 'bg-secondary-container text-on-secondary-container shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' }}">
            MINGGU INI
        </button>
        <button wire:click="setFilter('month')"
            class="snap-start shrink-0 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'month' ? 'bg-secondary-container text-on-secondary-container shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' }}">
            BULAN INI
        </button>
        <button wire:click="setFilter('all')"
            class="snap-start shrink-0 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'all' ? 'bg-secondary-container text-on-secondary-container shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' }}">
            SEMUA
        </button>
    </div>

    <!-- Banner Total Periode Ini DENGAN TEKS & IKON HITAM PEKAT -->
    <div class="w-full bg-primary-fixed border-2 border-outline-variant p-sm flex justify-between items-center shadow-[6px_6px_0px_0px_rgb(var(--color-shadow-ink))]">
        <div class="flex flex-col">
            <span class="font-sans text-label-caps font-bold text-black">Total Periode Ini</span>
            <span class="font-display text-headline-md text-black">
                {{ $totalPeriod >= 0 ? '+' : '-' }} Rp {{ number_format(abs($totalPeriod), 0, ',', '.') }}
            </span>
        </div>
        <span class="material-symbols-outlined text-4xl text-black">monitoring</span>
    </div>

    <!-- Transaction List -->
    <div class="flex flex-col gap-base">
        @forelse ($groupedTransactions as $date => $transactions)
            <h3 class="font-sans text-label-caps font-bold text-on-surface-variant mb-1 mt-2">{{ $date }}</h3>

            @foreach ($transactions as $transaction)
                <div wire:key="tx-{{ $transaction->id }}"
                    class="group relative flex items-center gap-sm p-sm bg-surface-container border-2 border-outline-variant shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))] transition-all">
                    <div class="w-12 h-12 flex items-center justify-center border-2 border-outline-variant shrink-0 {{ $transaction->type === 'income' ? 'bg-secondary' : 'bg-tertiary' }}">
                        <span class="material-symbols-outlined {{ $transaction->type === 'income' ? 'text-on-secondary' : 'text-on-tertiary' }} text-2xl">
                            {{ $transaction->type === 'income' ? 'payments' : 'shopping_bag' }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0 flex flex-col justify-center">
                        <span class="font-display text-title-sm text-on-surface truncate">{{ $transaction->title }}</span>
                        <div class="flex items-center gap-2 mt-1 text-on-surface-variant font-sans text-label-caps">
                            <span>{{ $transaction->created_at->format('H:i') }}</span>
                            <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
                            <span class="px-2 py-0.5 border border-outline-variant bg-surface">{{ $transaction->category->name }}</span>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="font-sans text-mono-data block {{ $transaction->type === 'income' ? 'text-secondary' : 'text-tertiary' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endforeach
        @empty
            <div class="bg-surface-container border-2 border-outline-variant p-lg text-center">
                <p class="font-sans text-body-md text-on-surface-variant">Belum ada transaksi di periode ini.</p>
            </div>
        @endforelse
    </div>
</div>