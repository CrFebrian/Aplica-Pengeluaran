<?php

namespace Tests\Feature;

use App\Livewire\Transactions\TransactionForm;
use App\Livewire\Transactions\TransactionList;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_transactions_page_is_displayed(): void
    {
        $response = $this->actingAs($this->user)->get('/transactions');

        $response->assertOk();

        Livewire::test(TransactionList::class)
            ->assertOk();
    }

    public function test_unauthenticated_user_cannot_access_transactions(): void
    {
        $this->get('/transactions')->assertRedirect('/login');
    }

    public function test_transaction_can_be_created_with_valid_data(): void
    {
        $category = Category::factory()->expense()->create(['user_id' => $this->user->id]);

        Livewire::actingAs($this->user)
            ->test(TransactionForm::class)
            ->set('type', 'expense')
            ->set('title', 'Makan Siang')
            ->set('amount', '50000')
            ->set('category_id', $category->id)
            ->set('transaction_date', now()->toDateString())
            ->set('note', 'Makan di warung')
            ->call('save')
            ->assertDispatched('transaction-saved');

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'title' => 'Makan Siang',
            'amount' => '50000.00',
            'type' => 'expense',
            'category_id' => $category->id,
        ]);
    }

    public function test_transaction_creation_validates_required_fields(): void
    {
        Livewire::actingAs($this->user)
            ->test(TransactionForm::class)
            ->call('save')
            ->assertHasErrors(['title', 'amount', 'category_id']);
    }

    public function test_transaction_creation_validates_amount_is_numeric(): void
    {
        $category = Category::factory()->expense()->create(['user_id' => $this->user->id]);

        Livewire::actingAs($this->user)
            ->test(TransactionForm::class)
            ->set('type', 'expense')
            ->set('title', 'Test')
            ->set('amount', 'bukan-angka')
            ->set('category_id', $category->id)
            ->set('transaction_date', now()->toDateString())
            ->call('save')
            ->assertHasErrors(['amount']);
    }

    public function test_transaction_creation_validates_type_enum(): void
    {
        Livewire::actingAs($this->user)
            ->test(TransactionForm::class)
            ->set('type', 'invalid-type')
            ->call('save')
            ->assertHasErrors(['type']);
    }

    public function test_expense_categories_shown_when_type_expense(): void
    {
        Category::factory()->expense()->create(['user_id' => $this->user->id, 'name' => 'Makanan']);
        Category::factory()->income()->create(['user_id' => $this->user->id, 'name' => 'Gaji']);

        Livewire::actingAs($this->user)
            ->test(TransactionForm::class)
            ->call('openModal')
            ->set('type', 'expense')
            ->assertSee('Makanan')
            ->assertDontSee('Gaji');
    }

    public function test_income_categories_shown_when_type_income(): void
    {
        Category::factory()->expense()->create(['user_id' => $this->user->id, 'name' => 'Makanan']);
        Category::factory()->income()->create(['user_id' => $this->user->id, 'name' => 'Gaji']);

        Livewire::actingAs($this->user)
            ->test(TransactionForm::class)
            ->call('openModal')
            ->set('type', 'income')
            ->assertSee('Gaji')
            ->assertDontSee('Makanan');
    }

    public function test_transaction_list_shows_today_transactions(): void
    {
        $category = Category::factory()->expense()->create(['user_id' => $this->user->id]);

        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'title' => 'Makan Hari Ini',
            'transaction_date' => now(),
        ]);

        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'title' => 'Makan Kemarin',
            'transaction_date' => now()->subDay(),
        ]);

        Livewire::actingAs($this->user)
            ->test(TransactionList::class)
            ->set('filter', 'today')
            ->assertSee('Makan Hari Ini')
            ->assertDontSee('Makan Kemarin');
    }

    public function test_transaction_list_filter_by_week(): void
    {
        $category = Category::factory()->expense()->create(['user_id' => $this->user->id]);

        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'title' => 'Minggu Ini',
            'transaction_date' => now(),
        ]);

        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'title' => 'Bulan Lalu',
            'transaction_date' => now()->subMonth(),
        ]);

        Livewire::actingAs($this->user)
            ->test(TransactionList::class)
            ->set('filter', 'week')
            ->assertSee('Minggu Ini')
            ->assertDontSee('Bulan Lalu');
    }
}
