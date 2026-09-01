<div wire:key="tx-{{ $transaction->id }}"
    style="--tx-delay: {{ ($index ?? 0) * 45 }}ms"
    class="tx-card tx-enter group relative flex items-center gap-2 sm:gap-sm p-2.5 sm:p-sm bg-surface-container border-2 border-outline-variant shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))] transition-all mb-2">
    <div class="w-9 h-9 sm:w-12 sm:h-12 flex items-center justify-center border-2 border-outline-variant shrink-0 {{ $transaction->type === 'income' ? 'bg-secondary' : 'bg-tertiary' }} group-hover:rotate-6 transition-transform">
        <span class="material-symbols-outlined {{ $transaction->type === 'income' ? 'text-on-secondary' : 'text-on-tertiary' }} text-lg sm:text-2xl">
            {{ $transaction->type === 'income' ? 'payments' : 'shopping_bag' }}
        </span>
    </div>
    <div class="flex-1 min-w-0 flex flex-col justify-center">
        <span class="font-display text-sm sm:text-title-sm text-on-surface truncate">{{ $transaction->title }}</span>
        <div class="flex items-center gap-1.5 sm:gap-2 mt-0.5 sm:mt-1 text-on-surface-variant font-sans text-[10px] sm:text-label-caps">
            <span>{{ $transaction->created_at->format('H:i') }}</span>
            <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
            <span class="px-1.5 sm:px-2 py-0.5 border border-outline-variant bg-surface">{{ $transaction->category->name }}</span>
        </div>
    </div>
    <div class="text-right shrink-0">
        <span class="font-sans text-xs sm:text-mono-data block {{ $transaction->type === 'income' ? 'text-secondary' : 'text-tertiary' }}">
            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
        </span>
    </div>
</div>