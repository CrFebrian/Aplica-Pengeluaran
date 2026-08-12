<?php

namespace App\Livewire\Transactions;

use App\Models\Category;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;

class TransactionForm extends Component
{
    // modal open/close state, dikontrol lewat event dari FAB (app.blade.php)
    public bool $showModal = false;

    // form fields sesuai skema tabel transactions
    public string $type = 'expense';
    public string $title = '';
    public string $amount = '';
    public ?int $category_id = null;
    public string $transaction_date;
    public string $note = '';

    public function mount(): void
    {
        $this->transaction_date = now()->toDateString();
    }

    protected function rules(): array
    {
        return [
            'type' => 'required|in:income,expense',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string|max:1000',
        ];
    }

    // kategori difilter sesuai tab type yang aktif (income/expense)
    public function getCategoriesProperty()
    {
        return Category::where('user_id', auth()->id())
            ->where('type', $this->type)
            ->orderBy('name')
            ->get();
    }

    #[On('open-transaction-form')]
    public function openModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    // reset kategori terpilih saat tab type berganti
    public function updatedType(): void
    {
        $this->category_id = null;
    }

    public function save(): void
    {
        $validated = $this->validate();

        Transaction::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'transaction_date' => $validated['transaction_date'],
            'note' => $validated['note'] ?: null,
        ]);

        $this->resetForm();
        $this->showModal = false;
        $this->dispatch('transaction-saved');

        // angka totalnya ikut update.
        if (! request()->routeIs('transactions.*')) {
            $this->redirect(url()->previous(), navigate: false);
        }
    }

    protected function resetForm(): void
    {
        $this->type = 'expense';
        $this->title = '';
        $this->amount = '';
        $this->category_id = null;
        $this->transaction_date = now()->toDateString();
        $this->note = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.transactions.transaction-form', [
            'categories' => $this->categories,
        ]);
    }
}