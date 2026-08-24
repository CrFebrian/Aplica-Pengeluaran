<div class="flex flex-col gap-md">
    <div class="flex flex-col mb-1 sm:mb-2">
        <h2 class="font-display text-2xl sm:text-headline-md font-bold text-on-surface uppercase">BUKU HUTANG</h2>
        <p class="font-sans text-base sm:text-lg text-on-surface-variant mt-1">Catatan utang lo nih, Biar nggak overthinking, pantau dan lunasin pelan-pelan ya bre!</p>
    </div>

    <div class="w-full bg-warning border-2 border-outline-variant p-sm flex justify-between items-center shadow-[6px_6px_0px_0px_rgb(var(--color-shadow-ink))]">
        <div class="flex flex-col">
            <span class="font-sans text-label-caps font-bold text-black">Total Hutang Aktif</span>
            <span class="font-display text-headline-md text-black">
                Rp {{ number_format($totalActiveDebt, 0, ',', '.') }}
            </span>
        </div>
        <span class="material-symbols-outlined text-4xl text-black">account_balance_wallet</span>
    </div>

    <div class="flex gap-sm">
        <button wire:click="setFilter('active')"
            class="flex-1 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'active' ? 'bg-warning text-on-warning shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' }}">
            AKTIF
        </button>
        <button wire:click="setFilter('paid')"
            class="flex-1 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'paid' ? 'bg-secondary-container text-on-secondary-container shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' }}">
            LUNAS
        </button>
        <button wire:click="setFilter('all')"
            class="flex-1 px-4 py-2 border-2 border-outline-variant font-sans text-label-caps font-bold transition-all {{ $filter === 'all' ? 'bg-primary-container text-white shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface hover:bg-surface-container-high shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' }}">
            SEMUA
        </button>
    </div>

    <div class="flex flex-col gap-sm">
        @forelse ($debts as $debt)
            @php
                $isOverdue = ! $debt->is_paid && $debt->due_date && $debt->due_date->isPast() && ! $debt->due_date->isToday();
                $isDueToday = ! $debt->is_paid && $debt->due_date && $debt->due_date->isToday();
            @endphp
            <div wire:key="debt-{{ $debt->id }}"
                class="relative bg-surface-container border-2 {{ $isOverdue ? 'border-tertiary' : 'border-outline-variant' }} p-sm shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))] flex flex-col gap-sm">

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
                                Waktu: {{ $debt->due_date->translatedFormat('d M') }}
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
                        <button type="button"
                            wire:click="confirmMarkAsPaid({{ $debt->id }})"
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

    <!-- Modal Konfirmasi Tandai Lunas -->
    @if ($confirmingDebt)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">

            <div wire:click="cancelMarkAsPaid" class="absolute inset-0 bg-black/50"></div>
            <div class="relative w-full max-w-sm bg-surface-container border-2 border-outline-variant shadow-[6px_6px_0px_0px_rgb(var(--color-shadow-ink))] p-md flex flex-col gap-sm">

                <div class="flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">task_alt</span>
                    <h3 class="font-display text-title-sm text-on-surface">TANDAI LUNAS</h3>
                </div>

                <p class="font-sans text-body-md text-on-surface-variant">
                    Tandai hutang <span class="font-bold text-on-surface">{{ $confirmingDebt->creditor_name }}</span>
                    sebesar <span class="font-bold text-on-surface">Rp {{ number_format($confirmingDebt->amount, 0, ',', '.') }}</span>
                    ini sebagai lunas?
                </p>

                <div class="flex gap-sm mt-xs">
                    <button type="button" wire:click="cancelMarkAsPaid"
                        class="flex-1 px-4 py-2 bg-surface-container-low text-on-surface border-2 border-outline-variant font-sans text-label-caps font-bold shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[2px_2px_0px_0px_rgb(var(--color-shadow-ink))] transition-all">
                        BATAL
                    </button>
                    <button type="button" wire:click="markAsPaid"
                        class="flex-1 px-4 py-2 bg-primary text-white border-2 border-outline-variant font-sans text-label-caps font-bold shadow-[4px_4px_0px_0px_#4f46e5] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[2px_2px_0px_0px_#4f46e5] transition-all">
                        YA, LUNAS
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>