<div class="flex flex-col gap-md">

    {{-- Screen Header --}}
    <h2 class="font-display text-headline-md text-on-surface uppercase">Buku Hutang</h2>

    {{-- Summary Banner --}}
    <div class="w-full bg-warning border-2 border-outline-variant p-sm flex justify-between items-center shadow-[6px_6px_0px_0px_#464554]">
        <div class="flex flex-col">
            <span class="font-sans text-label-caps font-bold text-on-warning">Total Hutang Aktif</span>
            <span class="font-display text-headline-md text-on-warning">
                Rp {{ number_format($totalActiveDebt, 0, ',', '.') }}
            </span>
        </div>
        <span class="material-symbols-outlined text-4xl text-on-warning opacity-50">account_balance_wallet</span>
    </div>

    {{-- Filter Row --}}
    <div class="flex gap-sm">
        <button wire:click="setFilter('active')"
            class="flex-1 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'active' ? 'bg-warning text-on-warning shadow-[4px_4px_0px_0px_#464554]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_#464554]' }}">
            AKTIF
        </button>
        <button wire:click="setFilter('paid')"
            class="flex-1 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'paid' ? 'bg-secondary-container text-on-secondary-container shadow-[4px_4px_0px_0px_#464554]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_#464554]' }}">
            LUNAS
        </button>
        <button wire:click="setFilter('all')"
            class="flex-1 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'all' ? 'bg-primary-container text-white shadow-[4px_4px_0px_0px_#464554]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_#464554]' }}">
            SEMUA
        </button>
    </div>

    {{-- Debt List --}}
    <div class="flex flex-col gap-sm">
        @forelse ($debts as $debt)
            @php
                $isOverdue = ! $debt->is_paid && $debt->due_date && $debt->due_date->isPast() && ! $debt->due_date->isToday();
                $isDueToday = ! $debt->is_paid && $debt->due_date && $debt->due_date->isToday();
            @endphp
            <div wire:key="debt-{{ $debt->id }}"
                class="relative bg-surface-container border-2 {{ $isOverdue ? 'border-tertiary' : 'border-outline-variant' }} p-sm shadow-[4px_4px_0px_0px_#464554] flex flex-col gap-sm">

                <div class="flex justify-between items-start gap-sm">
                    <div class="flex flex-col">
                        <span class="font-display text-title-sm text-on-surface">{{ $debt->creditor_name }}</span>
                        @if ($debt->note)
                            <span class="font-sans text-body-md text-on-surface-variant">{{ $debt->note }}</span>
                        @endif
                    </div>

                    @if (! $debt->is_paid && $debt->due_date)
                        <span class="shrink-0 px-2 py-1 border-2 font-sans text-label-caps font-bold {{ $isOverdue || $isDueToday ? 'bg-tertiary text-on-tertiary border-outline-variant' : 'bg-surface text-on-surface-variant border-outline-variant' }}">
                            @if ($isDueToday)
                                JATUH TEMPO HARI INI
                            @elseif ($isOverdue)
                                TERLAMBAT
                            @else
                                DUE: {{ $debt->due_date->translatedFormat('d M') }}
                            @endif
                        </span>
                    @elseif ($debt->is_paid)
                        <span class="shrink-0 px-2 py-1 border-2 border-outline-variant bg-secondary text-on-secondary font-sans text-label-caps font-bold">
                            LUNAS
                        </span>
                    @endif
                </div>

                <div class="flex justify-between items-center pt-sm border-t-2 border-outline-variant">
                    <div class="flex flex-col">
                        <span class="font-sans text-label-caps font-bold text-on-surface-variant">
                            {{ $debt->is_paid ? 'TOTAL DIBAYAR' : 'TOTAL HUTANG' }}
                        </span>
                        <span class="font-display text-title-sm {{ $debt->is_paid ? 'text-secondary' : 'text-warning' }}">
                            Rp {{ number_format($debt->amount, 0, ',', '.') }}
                        </span>
                    </div>

                    @unless ($debt->is_paid)
                        <button wire:click="markAsPaid({{ $debt->id }})" wire:confirm="Tandai hutang ini sebagai lunas?"
                            class="px-4 py-2 bg-primary text-white border-2 border-outline-variant font-sans text-label-caps font-bold shadow-[4px_4px_0px_0px_#4f46e5] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[2px_2px_0px_0px_#4f46e5] transition-all">
                            TANDAI LUNAS
                        </button>
                    @endunless
                </div>
            </div>
        @empty
            <div class="bg-surface-container border-2 border-outline-variant p-lg text-center">
                <p class="font-sans text-body-md text-on-surface-variant">
                    @if ($filter === 'paid')
                        Belum ada hutang yang lunas.
                    @else
                        Tidak ada catatan hutang.
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    <livewire:debts.debt-form />
</div>