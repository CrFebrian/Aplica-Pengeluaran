<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class TransactionList extends Component
{
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
        $transactions = $this->baseQuery()
            ->orderByDesc('transaction_date')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn (Transaction $t) => $t->transaction_date->translatedFormat('d F Y'));

        $totalPeriod = $this->baseQuery()->get()->sum(
            fn (Transaction $t) => $t->type === 'income' ? $t->amount : -$t->amount
        );

        return view('livewire.transactions.transaction-list', [
            'groupedTransactions' => $transactions,
            'totalPeriod' => $totalPeriod,
        ]);
    }
}