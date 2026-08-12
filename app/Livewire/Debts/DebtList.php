<?php

namespace App\Livewire\Debts;

use App\Models\Debt;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class DebtList extends Component
{
    // Filter status hutang yang ditampilkan di list. Default: active (belum dibayar)
    public string $filter = 'active';

    #[On('debt-saved')]
    public function refreshList(): void
    {
        // no-op, render() otomatis re-query
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    public function markAsPaid(int $debtId): void
    {
        $debt = Debt::where('user_id', auth()->id())->findOrFail($debtId);

        $debt->update([
            'is_paid' => true,
            'paid_at' => now()->toDateString(),
        ]);
    }

    public function render()
    {
        $query = Debt::where('user_id', auth()->id());

        $debts = match ($this->filter) {
            'paid' => $query->where('is_paid', true),
            'all' => $query,
            default => $query->where('is_paid', false),
        };

        $debts = $debts->orderByRaw('due_date IS NULL, due_date ASC')->get();

        $totalActiveDebt = Debt::where('user_id', auth()->id())->where('is_paid', false)->sum('amount');

        return view('livewire.debts.debt-list', [
            'debts' => $debts,
            'totalActiveDebt' => $totalActiveDebt,
        ]);
    }
}