<div class="flex flex-col gap-md">
    <div class="flex flex-col mb-1 sm:mb-2">
        <h2 class="font-display text-2xl sm:text-headline-md font-bold text-on-surface uppercase">DAFTAR TRANSAKSI</h2>
        <p class="font-sans text-base sm:text-lg text-on-surface-variant mt-1">Jejak cuan dan pengeluaran lo nih, bre!</p>
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
    <div class="w-full bg-primary-fixed border-2 border-outline-variant p-3 sm:p-sm flex justify-between items-center shadow-[6px_6px_0px_0px_rgb(var(--color-shadow-ink))]">
        <div class="flex flex-col">
            <span class="font-sans text-[10px] sm:text-label-caps font-bold text-black uppercase tracking-wide">Total Periode Ini</span>
            <span class="font-display text-lg sm:text-headline-md font-bold text-black">
                {{ $totalPeriod >= 0 ? '+' : '-' }} Rp {{ number_format(abs($totalPeriod), 0, ',', '.') }}
            </span>
        </div>
        <span class="material-symbols-outlined text-2xl sm:text-4xl text-black">monitoring</span>
    </div>

    @if ($filter === 'all')
        <h3 class="font-display text-base sm:text-title-sm font-bold text-on-surface uppercase mt-2 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-primary"></span>
            Histori Transaksi
        </h3>

        @if ($incomeByDate->isEmpty() && $expenseByDate->isEmpty())
            <div class="bg-surface-container border-2 border-outline-variant p-lg text-center">
                <p class="font-sans text-body-md text-on-surface-variant">Belum ada transaksi.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-md items-start" wire:transition.duration.300ms>
                <div class="flex flex-col bg-surface-container-low border-2 border-secondary p-sm gap-base">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        <span class="font-sans text-label-caps font-bold text-secondary">PEMASUKAN</span>
                    </div>

                    @php $incIndex = 0; @endphp
                    @forelse ($incomeByDate as $date => $transactions)
                        <div>
                            <h4 class="font-sans text-[11px] sm:text-label-caps font-bold text-on-surface-variant mb-1 uppercase tracking-wide">{{ $date }}</h4>
                            @foreach ($transactions as $transaction)
                                @include('livewire.transactions.partials.transaction-card', ['index' => $incIndex++])
                            @endforeach
                        </div>
                    @empty
                        <p class="font-sans text-body-md text-on-surface-variant text-center py-sm">Belum ada pemasukan.</p>
                    @endforelse
                    @include('livewire.transactions.partials.pagination-controls', ['paginator' => $incomePaginator, 'pageName' => 'page_masuk'])
                </div>

                <div class="flex flex-col bg-surface-container-low border-2 border-tertiary p-sm gap-base">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                        <span class="font-sans text-label-caps font-bold text-tertiary">PENGELUARAN</span>
                    </div>

                    @php $expIndex = 0; @endphp
                    @forelse ($expenseByDate as $date => $transactions)
                        <div>
                            <h4 class="font-sans text-[11px] sm:text-label-caps font-bold text-on-surface-variant mb-1 uppercase tracking-wide">{{ $date }}</h4>
                            @foreach ($transactions as $transaction)
                                @include('livewire.transactions.partials.transaction-card', ['index' => $expIndex++])
                            @endforeach
                        </div>
                    @empty
                        <p class="font-sans text-body-md text-on-surface-variant text-center py-sm">Belum ada pengeluaran.</p>
                    @endforelse

                    {{-- NEW: pagination khusus kolom Pengeluaran --}}
                    @include('livewire.transactions.partials.pagination-controls', ['paginator' => $expensePaginator, 'pageName' => 'page_keluar'])
                </div>
            </div>
        @endif
    @else
        <div class="flex flex-col gap-base" wire:transition.duration.300ms>
            <h3 class="font-display text-base sm:text-title-sm font-bold text-on-surface uppercase mt-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-primary"></span>
                Histori Transaksi
            </h3>
            @php $cardIndex = 0; @endphp
            @forelse ($groupedTransactions as $date => $transactionsByType)
                <h3 class="font-sans text-[11px] sm:text-label-caps font-bold text-on-surface-variant mb-1 mt-2 uppercase tracking-wide flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">calendar_month</span>
                    {{ $date }}
                </h3>

                @foreach ($transactionsByType as $type => $transactions)
                    <div class="flex items-center gap-2 mt-1 mb-1">
                        <span class="w-2 h-2 rounded-full {{ $type === 'income' ? 'bg-secondary' : 'bg-tertiary' }}"></span>
                        <span class="font-sans text-[10px] sm:text-label-caps font-bold {{ $type === 'income' ? 'text-secondary' : 'text-tertiary' }}">
                            {{ $type === 'income' ? 'PEMASUKAN' : 'PENGELUARAN' }}
                        </span>
                    </div>

                    @foreach ($transactions as $transaction)
                        @include('livewire.transactions.partials.transaction-card', ['index' => $cardIndex++])
                    @endforeach
                @endforeach
            @empty
                <div class="bg-surface-container border-2 border-outline-variant p-lg text-center">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2 block">receipt_long</span>
                    <p class="font-sans text-sm sm:text-body-md text-on-surface-variant">Belum ada transaksi di periode ini.</p>
                </div>
            @endforelse
            @include('livewire.transactions.partials.pagination-controls', ['paginator' => $paginator, 'pageName' => 'page'])
        </div>
    @endif
</div>