<?php

namespace App\Livewire\Debts;

use App\Models\Debt;
use Livewire\Attributes\On;
use Livewire\Component;

class DebtForm extends Component
{
    public bool $showModal = false;

    public string $creditor_name = '';
    public string $amount = '';
    public ?string $due_date = null;
    public string $note = '';

    protected function rules(): array
    {
        return [
            'creditor_name' => 'required|string|max:50',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'nullable|date',
            'note' => 'nullable|string|max:1000',
        ];
    }

    #[On('open-debt-form')]
    public function openModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $validated = $this->validate();

        Debt::create([
            'user_id' => auth()->id(),
            'creditor_name' => $validated['creditor_name'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'] ?: null,
            'note' => $validated['note'] ?: null,
            'is_paid' => false,
        ]);

        $this->resetForm();
        $this->showModal = false;
        $this->dispatch('debt-saved');
        // Notify success
        $this->dispatch('notify-success', message: 'Data Hutang Sudah Ditambahkan');
    }

    protected function resetForm(): void
    {
        $this->creditor_name = '';
        $this->amount = '';
        $this->due_date = null;
        $this->note = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.debts.debt-form');
    }
}