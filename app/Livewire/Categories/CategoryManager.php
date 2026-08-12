<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CategoryManager extends Component
{
    public string $activeType = 'expense';

    // state form (dipakai untuk tambah maupun edit, dibedakan lewat $editingId)
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public ?string $deleteError = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function setActiveType(string $type): void
    {
        $this->activeType = $type;
        $this->deleteError = null;
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal(int $categoryId): void
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($categoryId);

        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->editingId) {
            Category::where('user_id', auth()->id())
                ->findOrFail($this->editingId)
                ->update(['name' => $validated['name']]);
        } else {
            Category::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'type' => $this->activeType,
            ]);
        }

        $this->resetForm();
        $this->showModal = false;
    }

    // cegah hapus kategori yang masih dipakai transaksi
    // akan ikut menghapus semua transaksi terkait jika dipaksa hapus.
    public function delete(int $categoryId): void
    {
        $category = Category::where('user_id', auth()->id())->withCount('transactions')->findOrFail($categoryId);

        if ($category->transactions_count > 0) {
            $this->deleteError = "Kategori \"{$category->name}\" tidak bisa dihapus karena masih dipakai di {$category->transactions_count} transaksi.";

            return;
        }

        $category->delete();
        $this->deleteError = null;
    }

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $categories = Category::where('user_id', auth()->id())
            ->where('type', $this->activeType)
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        return view('livewire.categories.category-manager', [
            'categories' => $categories,
        ]);
    }
}