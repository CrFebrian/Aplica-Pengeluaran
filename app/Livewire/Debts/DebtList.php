<?php

namespace App\Livewire\Debts;

use App\Models\Debt;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class DebtList extends Component
{
    public string $filter = 'active';
    public ?int $confirmingDebtId = null;

    #[On('debt-saved')]
    public function refreshList(): void
    {
        // no-op, render() otomatis re-query
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    public function confirmMarkAsPaid(int $debtId): void
    {
        $this->confirmingDebtId = $debtId;
    }

    public function cancelMarkAsPaid(): void
    {
        $this->confirmingDebtId = null;
    }

    public function markAsPaid(): void
    {
        if (! $this->confirmingDebtId) {
            return;
        }

        $debt = Debt::where('user_id', auth()->id())->findOrFail($this->confirmingDebtId);

        $debtName = $debt->creditor_name;

        $debt->update([
            'is_paid' => true,
            'paid_at' => now()->toDateString(),
        ]);

        $this->confirmingDebtId = null;

        // Trigger popup sukses global (dengan animasi centang) saat hutang ditandai lunas
        $this->dispatch('notify-success', message: "Hutang \"{$debtName}\" Sudah Ditandai Lunas");
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

        // data hutang yang sedang dikonfirmasi, dipakai untuk tampilkan nama & nominal di modal
        $confirmingDebt = $this->confirmingDebtId
            ? Debt::where('user_id', auth()->id())->find($this->confirmingDebtId)
            : null;

        return view('livewire.debts.debt-list', [
            'debts' => $debts,
            'totalActiveDebt' => $totalActiveDebt,
            'confirmingDebt' => $confirmingDebt,
        ]);
    }
}