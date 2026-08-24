<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CategoryManager extends Component
{
    public string $activeType = 'expense';

    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';

    public ?string $deleteError = null;

    // id kategori yang sedang dikonfirmasi untuk dihapus
    public ?int $confirmingDeleteId = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
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

        $isEditing = (bool) $this->editingId;

        if ($isEditing) {
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

        // trigger popup sukses global
        $this->dispatch(
            'notify-success',
            message: $isEditing ? 'Data Kategori Sudah Diubah' : 'Data Kategori Sudah Ditambahkan'
        );
    }

    public function confirmDelete(int $categoryId): void
    {
        $this->deleteError = null;
        $this->confirmingDeleteId = $categoryId;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteId = null;
    }

    // akan ikut menghapus semua transaksi terkait jika dipaksa hapus.
    public function delete(): void
    {
        if (! $this->confirmingDeleteId) {
            return;
        }

        $category = Category::where('user_id', auth()->id())->withCount('transactions')->findOrFail($this->confirmingDeleteId);

        if ($category->transactions_count > 0) {
            $this->deleteError = "Kategori \"{$category->name}\" tidak bisa dihapus karena masih dipakai di {$category->transactions_count} transaksi.";
            $this->confirmingDeleteId = null;

            return;
        }

        $categoryName = $category->name;
        $category->delete();

        $this->deleteError = null;
        $this->confirmingDeleteId = null;

        // Trigger popup sukses global
        $this->dispatch('notify-success', message: "Kategori \"{$categoryName}\" Sudah Dihapus");
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

        $confirmingCategory = $this->confirmingDeleteId
            ? Category::where('user_id', auth()->id())->find($this->confirmingDeleteId)
            : null;

        return view('livewire.categories.category-manager', [
            'categories' => $categories,
            'confirmingCategory' => $confirmingCategory,
        ]);
    }
}