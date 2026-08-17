<?php

namespace Tests\Feature;

use App\Livewire\Categories\CategoryManager;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_categories_page_is_displayed(): void
    {
        $response = $this->actingAs($this->user)->get('/categories');

        $response->assertOk();

        Livewire::test(CategoryManager::class)
            ->assertOk();
    }

    public function test_unauthenticated_user_cannot_access_categories(): void
    {
        $this->get('/categories')->assertRedirect('/login');
    }

    public function test_category_can_be_created(): void
    {
        Livewire::actingAs($this->user)
            ->test(CategoryManager::class)
            ->call('openCreateModal')
            ->set('name', 'Makanan')
            ->call('save');

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'name' => 'Makanan',
            'type' => 'expense',
        ]);
    }

    public function test_category_creation_validates_name_required(): void
    {
        Livewire::actingAs($this->user)
            ->test(CategoryManager::class)
            ->call('openCreateModal')
            ->call('save')
            ->assertHasErrors(['name']);
    }

    public function test_category_can_be_edited(): void
    {
        $category = Category::factory()->expense()->create([
            'user_id' => $this->user->id,
            'name' => 'Lama',
        ]);

        Livewire::actingAs($this->user)
            ->test(CategoryManager::class)
            ->call('openEditModal', $category->id)
            ->set('name', 'Baru')
            ->call('save');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Baru',
        ]);
    }

    public function test_category_can_be_deleted_when_no_transactions(): void
    {
        $category = Category::factory()->expense()->create([
            'user_id' => $this->user->id,
        ]);

        Livewire::actingAs($this->user)
            ->test(CategoryManager::class)
            ->call('delete', $category->id);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_category_cannot_be_deleted_when_has_transactions(): void
    {
        $category = Category::factory()->expense()->create([
            'user_id' => $this->user->id,
            'name' => 'Penting',
        ]);

        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
        ]);

        Livewire::actingAs($this->user)
            ->test(CategoryManager::class)
            ->call('delete', $category->id)
            ->assertSet('deleteError', "Kategori \"Penting\" tidak bisa dihapus karena masih dipakai di 1 transaksi.");

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_switching_type_tab_updates_categories(): void
    {
        Category::factory()->expense()->create(['user_id' => $this->user->id, 'name' => 'Belanja']);
        Category::factory()->income()->create(['user_id' => $this->user->id, 'name' => 'Gaji']);

        Livewire::actingAs($this->user)
            ->test(CategoryManager::class)
            ->assertSee('Belanja')
            ->assertDontSee('Gaji')
            ->call('setActiveType', 'income')
            ->assertSee('Gaji')
            ->assertDontSee('Belanja');
    }
}
