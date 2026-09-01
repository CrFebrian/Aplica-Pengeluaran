<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class TransactionList extends Component
{
    use WithPagination;

    // NEW: 15 transaksi per halaman, sesuai permintaan.
    protected int $perPage = 15;

    //filter periode aktif — today | week | month | all
    public string $filter = 'today';

    #[On('transaction-saved')]
    public function refreshList(): void
    {
        // no-op, render() akan otomatis re-query
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage('page');
        $this->resetPage('page_masuk');
        $this->resetPage('page_keluar');
    }

    protected function baseQuery()
    {
        $query = Transaction::with('category')
            ->where('user_id', auth()->id());

        return match ($this->filter) {
            'today' => $query->whereDate('transaction_date', Carbon::today()),
            'week' => $query->whereBetween('transaction_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
            'month' => $query->whereMonth('transaction_date', Carbon::now()->month)->whereYear('transaction_date', Carbon::now()->year),
            default => $query,
        };
    }

    public function render()
    {
        $groupedTransactions = null;
        $paginator = null;

        $incomeByDate = null;
        $expenseByDate = null;
        $incomePaginator = null;
        $expensePaginator = null;

        if ($this->filter === 'all') {
            // masing-masing dipaginate independen (15 per halaman) lewat pageName
            $incomePaginator = $this->baseQuery()
                ->where('type', 'income')
                ->orderByDesc('transaction_date')
                ->orderByDesc('created_at')
                ->paginate($this->perPage, ['*'], 'page_masuk');

            $expensePaginator = $this->baseQuery()
                ->where('type', 'expense')
                ->orderByDesc('transaction_date')
                ->orderByDesc('created_at')
                ->paginate($this->perPage, ['*'], 'page_keluar');

            $incomeByDate = collect($incomePaginator->items())
                ->groupBy(fn (Transaction $t) => $t->transaction_date->translatedFormat('d F Y'));

            $expenseByDate = collect($expensePaginator->items())
                ->groupBy(fn (Transaction $t) => $t->transaction_date->translatedFormat('d F Y'));
        } else {
            // sedang tampil baru dikelompokkan per tanggal lalu per tipe.
            $paginator = $this->baseQuery()
                ->orderByDesc('transaction_date')
                ->orderByDesc('created_at')
                ->paginate($this->perPage, ['*'], 'page');

            $groupedTransactions = collect($paginator->items())
                ->groupBy(fn (Transaction $t) => $t->transaction_date->translatedFormat('d F Y'))
                ->map(function ($transactionsOnDate) {
                    return $transactionsOnDate
                        ->groupBy('type')
                        ->sortKeysUsing(fn ($a, $b) => $a === 'income' ? -1 : ($b === 'income' ? 1 : 0));
                });
        }

        $totalPeriod = $this->baseQuery()->get()->sum(
            fn (Transaction $t) => $t->type === 'income' ? $t->amount : -$t->amount
        );

        return view('livewire.transactions.transaction-list', [
            'groupedTransactions' => $groupedTransactions,
            'paginator' => $paginator,
            'incomeByDate' => $incomeByDate,
            'expenseByDate' => $expenseByDate,
            'incomePaginator' => $incomePaginator,
            'expensePaginator' => $expensePaginator,
            'totalPeriod' => $totalPeriod,
        ]);
    }
}