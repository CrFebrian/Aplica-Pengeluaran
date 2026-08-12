@php
    $user = auth()->user();
    $today = \Illuminate\Support\Carbon::today();

    $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
    $totalExpense = $user->transactions()->where('type', 'expense')->sum('amount');
    $totalSaldo = $totalIncome - $totalExpense;

    $incomeToday = $user->transactions()->where('type', 'income')->whereDate('transaction_date', $today)->sum('amount');
    $expenseToday = $user->transactions()->where('type', 'expense')->whereDate('transaction_date', $today)->sum('amount');

    $activeDebt = $user->debts()->where('is_paid', false)->orderBy('due_date')->first();

    $recentTransactions = $user->transactions()->with('category')->latest('transaction_date')->latest('id')->take(5)->get();
@endphp

<x-app-layout>

    <!-- Total Balance Card -->
    <section class="bg-surface-container-low p-sm neo-shadow border-2 border-outline-variant flex flex-col justify-center items-center text-center gap-xs">
        <h2 class="font-sans text-label-caps font-bold text-on-surface-variant">TOTAL SALDO</h2>
        <div class="font-display text-headline-md text-on-surface">
            Rp {{ number_format($totalSaldo, 0, ',', '.') }}
        </div>
    </section>

    <!-- Income/Expense Today -->
    <section class="grid grid-cols-2 gap-sm">
        <div class="bg-income text-[#064e3b] p-sm border-2 border-outline-variant neo-shadow-success flex flex-col gap-xs">
            <h3 class="font-sans text-label-caps font-bold opacity-90">PEMASUKAN HARI INI</h3>
            <div class="font-display text-title-sm">+Rp {{ number_format($incomeToday, 0, ',', '.') }}</div>
        </div>
        <div class="bg-expense text-[#881337] p-sm border-2 border-outline-variant neo-shadow-danger flex flex-col gap-xs">
            <h3 class="font-sans text-label-caps font-bold opacity-90">PENGELUARAN HARI INI</h3>
            <div class="font-display text-title-sm">-Rp {{ number_format($expenseToday, 0, ',', '.') }}</div>
        </div>
    </section>

    <!-- Active Debt Notification -->
    @if ($activeDebt)
        <section class="bg-warning text-on-warning p-sm border-2 border-outline-variant neo-shadow-warning flex flex-col gap-base">
            <div class="flex items-center gap-xs">
                <span class="material-symbols-outlined">warning</span>
                <h3 class="font-display text-title-sm">HUTANG AKTIF</h3>
            </div>
            <p class="font-sans text-body-md">
                {{ $activeDebt->creditor_name }}: Rp {{ number_format($activeDebt->amount, 0, ',', '.') }}
                @if ($activeDebt->due_date)
                    (Jatuh tempo {{ $activeDebt->due_date->isToday() ? 'hari ini' : $activeDebt->due_date->translatedFormat('d M Y') }})
                @endif
            </p>
        </section>
    @endif

    <!-- Recent Transactions -->
    <section class="bg-surface-container border-2 border-outline-variant neo-shadow overflow-hidden">
        <div class="p-sm border-b-2 border-outline-variant bg-surface-container-high">
            <h3 class="font-display text-title-sm text-on-surface">TRANSAKSI TERAKHIR</h3>
        </div>
        <div class="flex flex-col">
            @forelse ($recentTransactions as $transaction)
                <div class="transaction-row p-sm flex items-center justify-between hover:bg-surface-container-highest transition-colors cursor-pointer">
                    <div class="flex items-center gap-sm">
                        <div class="w-10 h-10 bg-surface-container-highest border-2 border-outline-variant flex items-center justify-center text-on-surface">
                            <span class="material-symbols-outlined">
                                {{ $transaction->type === 'income' ? 'payments' : 'shopping_bag' }}
                            </span>
                        </div>
                        <div class="flex flex-col gap-base">
                            <div class="font-sans text-body-lg text-on-surface">{{ $transaction->title }}</div>
                            <div class="flex items-center gap-xs">
                                <span class="bg-surface-container-highest text-on-surface-variant px-2 py-1 font-sans text-label-caps border-2 border-outline-variant">
                                    {{ $transaction->category->name }}
                                </span>
                                <span class="font-sans text-label-caps text-on-surface-variant">
                                    {{ $transaction->transaction_date->isToday() ? $transaction->created_at->format('H:i') : $transaction->transaction_date->translatedFormat('d M') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="font-sans text-mono-data {{ $transaction->type === 'income' ? 'text-income' : 'text-expense' }}">
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

</x-app-layout>