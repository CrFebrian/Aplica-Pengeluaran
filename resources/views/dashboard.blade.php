@php
    $user = auth()->user();
    $today = \Illuminate\Support\Carbon::today();
    $startOfMonth = \Illuminate\Support\Carbon::now()->startOfMonth();
    $endOfMonth = \Illuminate\Support\Carbon::now()->endOfMonth();
    $startOfPrevMonth = \Illuminate\Support\Carbon::now()->subMonthNoOverflow()->startOfMonth();
    $endOfPrevMonth = \Illuminate\Support\Carbon::now()->subMonthNoOverflow()->endOfMonth();

    $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
    $totalExpense = $user->transactions()->where('type', 'expense')->sum('amount');
    $totalSaldo = $totalIncome - $totalExpense;

    $incomeThisMonth = $user->transactions()->where('type', 'income')->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->sum('amount');
    $expenseThisMonth = $user->transactions()->where('type', 'expense')->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->sum('amount');

    $incomePrevMonth = $user->transactions()->where('type', 'income')->whereBetween('transaction_date', [$startOfPrevMonth, $endOfPrevMonth])->sum('amount');
    $expensePrevMonth = $user->transactions()->where('type', 'expense')->whereBetween('transaction_date', [$startOfPrevMonth, $endOfPrevMonth])->sum('amount');

    $incomeProgress = $incomePrevMonth > 0 ? min(100, round(($incomeThisMonth / $incomePrevMonth) * 100)) : ($incomeThisMonth > 0 ? 100 : 0);
    $expenseProgress = $expensePrevMonth > 0 ? min(100, round(($expenseThisMonth / $expensePrevMonth) * 100)) : ($expenseThisMonth > 0 ? 100 : 0);

    $netThisMonth = $incomeThisMonth - $expenseThisMonth;
    $netPrevMonth = $incomePrevMonth - $expensePrevMonth;
    $trendPercent = $netPrevMonth != 0 ? round((($netThisMonth - $netPrevMonth) / abs($netPrevMonth)) * 100) : null;

    $activeDebts = $user->debts()->where('is_paid', false)->orderByRaw('due_date IS NULL, due_date ASC')->take(4)->get();
    
    // Tambahan: Query untuk mengambil hutang yang sudah lunas
    $paidDebts = $user->debts()->where('is_paid', true)->latest('updated_at')->take(4)->get();

    $recentTransactions = $user->transactions()->with('category')->latest('transaction_date')->latest('id')->take(5)->get();
@endphp

<x-app-layout>
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-xs">
        <div>
            <h2 class="font-display text-headline-md text-on-surface uppercase">Dashboard</h2>
            <p class="font-sans text-base sm:text-lg text-on-surface-variant mt-1">Spill tipis-tipis kondisi keuangan lo hari ini, bre!</p>
        </div>
        <div class="inline-flex items-center gap-xs px-sm py-xs border-2 border-outline-variant bg-surface-container-low font-sans text-mono-data text-on-surface w-max">
            <span class="material-symbols-outlined text-outline text-lg">calendar_month</span>
            {{ $today->translatedFormat('F Y') }}
        </div>
    </div>
    <section class="relative overflow-hidden bg-surface-container-low p-md neo-shadow-primary border-2 border-outline-variant flex flex-col gap-xs">
        <h3 class="font-sans text-label-caps font-bold text-on-surface-variant">TOTAL SALDO</h3>
        <div class="flex items-center gap-sm flex-wrap">
            <div class="font-display text-headline-md sm:text-display-lg-mobile text-on-surface">
                Rp {{ number_format($totalSaldo, 0, ',', '.') }}
            </div>
            @if (! is_null($trendPercent))
                <span class="inline-flex items-center gap-1 font-sans text-mono-data {{ $trendPercent >= 0 ? 'text-income' : 'text-expense' }}">
                    <span class="material-symbols-outlined text-base">{{ $trendPercent >= 0 ? 'trending_up' : 'trending_down' }}</span>
                    {{ $trendPercent >= 0 ? '+' : '' }}{{ $trendPercent }}%
                </span>
            @endif
        </div>
    </section>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div class="bg-surface-container-low p-sm border-2 border-income neo-shadow flex flex-col gap-xs">
            <div class="flex items-center justify-between">
                <h3 class="font-sans text-label-caps font-bold text-on-surface-variant">PEMASUKAN BULAN INI</h3>
                <span class="material-symbols-outlined text-income">trending_up</span>
            </div>
            <div class="font-display text-title-sm text-income">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</div>
            <p class="font-sans text-body-md text-on-surface-variant">
                @if ($incomePrevMonth > 0)
                    {{ $incomeProgress }}% dari bulan lalu
                @else
                    Belum ada data bulan lalu
                @endif
            </p>
            <div class="w-full h-2 bg-surface-container-highest border border-outline-variant">
                <div class="h-full bg-income" style="width: {{ $incomeProgress }}%"></div>
            </div>
        </div>
        <div class="bg-surface-container-low p-sm border-2 border-expense neo-shadow flex flex-col gap-xs">
            <div class="flex items-center justify-between">
                <h3 class="font-sans text-label-caps font-bold text-on-surface-variant">PENGELUARAN BULAN INI</h3>
                <span class="material-symbols-outlined text-expense">trending_down</span>
            </div>
            <div class="font-display text-title-sm text-expense">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}</div>
            <p class="font-sans text-body-md text-on-surface-variant">
                @if ($expensePrevMonth > 0)
                    {{ $expenseProgress }}% dari bulan lalu
                @else
                    Belum ada data bulan lalu
                @endif
            </p>
            <div class="w-full h-2 bg-surface-container-highest border border-outline-variant">
                <div class="h-full bg-expense" style="width: {{ $expenseProgress }}%"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-md items-start">
        <!-- Recent Transactions (kolom kiri, lebih lebar) -->
        <section class="lg:col-span-3 bg-surface-container border-2 border-outline-variant neo-shadow overflow-hidden">
            <div class="p-sm border-b-2 border-outline-variant bg-surface-container-high flex items-center justify-between">
                <h3 class="font-display text-title-sm text-on-surface">TRANSAKSI TERAKHIR</h3>
                <a href="{{ Route::has('transactions.index') ? route('transactions.index') : '#' }}" wire:navigate class="font-sans text-body-md font-bold text-primary hover:underline">
                    Lihat Semua
                </a>
            </div>
            <div class="flex flex-col">
                @forelse ($recentTransactions as $transaction)
                    <div class="transaction-row p-sm flex items-center justify-between hover:bg-surface-container-highest transition-colors cursor-pointer">
                        <div class="flex items-center gap-sm min-w-0">
                            <div class="w-10 h-10 shrink-0 bg-surface-container-highest border-2 border-outline-variant flex items-center justify-center text-on-surface">
                                <span class="material-symbols-outlined">
                                    {{ $transaction->type === 'income' ? 'payments' : 'shopping_bag' }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-base min-w-0">
                                <div class="font-sans text-body-lg text-on-surface truncate">{{ $transaction->title }}</div>
                                <div class="flex items-center gap-xs flex-wrap">
                                    <span class="bg-surface-container-highest text-on-surface-variant px-2 py-1 font-sans text-label-caps border-2 border-outline-variant">
                                        {{ $transaction->category->name }}
                                    </span>
                                    <span class="font-sans text-label-caps text-on-surface-variant">
                                        {{ $transaction->transaction_date->isToday() ? $transaction->created_at->format('H:i') : $transaction->transaction_date->translatedFormat('d M') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="font-sans text-mono-data shrink-0 {{ $transaction->type === 'income' ? 'text-income' : 'text-expense' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="p-sm text-center font-sans text-body-md text-on-surface-variant">
                        Belum ada transaksi. Yuk mulai catat!
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Hutang Aktif & Hutang Lunas -->
        <div class="lg:col-span-2 flex flex-col gap-md">
            <section class="bg-surface-container border-2 border-tertiary neo-shadow-danger overflow-hidden">
                <div class="p-sm border-b-2 border-outline-variant bg-surface-container-high flex items-center justify-between">
                    <h3 class="font-display text-title-sm text-on-surface">HUTANG</h3>
                    @if ($activeDebts->isNotEmpty())
                        <span class="material-symbols-outlined text-tertiary">warning</span>
                    @endif
                </div>
                <div class="flex flex-col">
                    @forelse ($activeDebts as $debt)
                        @php
                            $isOverdue = $debt->due_date && $debt->due_date->isPast() && ! $debt->due_date->isToday();
                            $daysUntilDue = $debt->due_date ? $today->diffInDays($debt->due_date, false) : null;
                            $isDueSoon = ! $isOverdue && ! is_null($daysUntilDue) && $daysUntilDue >= 0 && $daysUntilDue <= 3;
                        @endphp
                        <div class="transaction-row p-sm flex items-center justify-between gap-sm border-b border-outline-variant/30 last:border-b-0">
                            <div class="min-w-0 flex flex-col gap-1">
                                <span class="font-sans text-body-lg text-on-surface truncate">{{ $debt->creditor_name }}</span>
                                @if ($debt->due_date)
                                    <span class="font-sans text-label-caps {{ $isOverdue ? 'text-tertiary' : ($isDueSoon ? 'text-warning' : 'text-on-surface-variant') }}">
                                        {{ $isOverdue ? 'Terlambat' : ($debt->due_date->isToday() ? 'Jatuh tempo hari ini' : 'Jatuh tempo ' . $debt->due_date->translatedFormat('d M')) }}
                                    </span>
                                @endif
                            </div>
                            <span class="font-sans text-mono-data text-tertiary shrink-0">
                                Rp {{ number_format($debt->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="p-sm text-center font-sans text-body-md text-on-surface-variant">
                            Tidak ada hutang aktif. Mantap!
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Section Hutang Lunas -->
            <section class="bg-surface-container border-2 border-income neo-shadow overflow-hidden">
                <div class="p-sm border-b-2 border-outline-variant bg-surface-container-high flex items-center justify-between">
                    <h3 class="font-display text-title-sm text-on-surface">HUTANG LUNAS</h3>
                    @if ($paidDebts->isNotEmpty())
                        <span class="material-symbols-outlined text-income">check_circle</span>
                    @endif
                </div>
                <div class="flex flex-col">
                    @forelse ($paidDebts as $debt)
                        <div class="transaction-row p-sm flex items-center justify-between gap-sm border-b border-outline-variant/30 last:border-b-0">
                            <div class="min-w-0 flex flex-col gap-1 opacity-70">
                                <!-- Tulisan nama dicoret (line-through) untuk menandakan lunas -->
                                <span class="font-sans text-body-lg text-on-surface truncate line-through">{{ $debt->creditor_name }}</span>
                            </div>
                            <span class="font-sans text-mono-data text-income shrink-0">
                                Rp {{ number_format($debt->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="p-sm text-center font-sans text-body-md text-on-surface-variant">
                            Belum ada histori hutang lunas.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>