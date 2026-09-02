<?php

namespace Tests\Feature;

use App\Livewire\Debts\DebtForm;
use App\Livewire\Debts\DebtList;
use App\Models\Debt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DebtTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_debts_page_is_displayed(): void
    {
        $response = $this->actingAs($this->user)->get('/debts');

        $response->assertOk();

        Livewire::test(DebtList::class)
            ->assertOk();
    }

    public function test_unauthenticated_user_cannot_access_debts(): void
    {
        $this->get('/debts')->assertRedirect('/login');
    }

    public function test_debt_can_be_created_with_valid_data(): void
    {
        Livewire::actingAs($this->user)
            ->test(DebtForm::class)
            ->set('creditor_name', 'Bank BCA')
            ->set('amount', '5000000')
            ->set('due_date', now()->addMonth()->toDateString())
            ->set('note', 'Pinjaman modal')
            ->call('save')
            ->assertDispatched('debt-saved');

        $this->assertDatabaseHas('debts', [
            'user_id' => $this->user->id,
            'creditor_name' => 'Bank BCA',
            'amount' => '5000000.00',
            'is_paid' => false,
        ]);
    }

    public function test_debt_creation_validates_required_fields(): void
    {
        Livewire::actingAs($this->user)
            ->test(DebtForm::class)
            ->call('save')
            ->assertHasErrors(['creditor_name', 'amount']);
    }

    public function test_debt_creation_validates_amount_is_numeric(): void
    {
        Livewire::actingAs($this->user)
            ->test(DebtForm::class)
            ->set('creditor_name', 'Test')
            ->set('amount', 'bukan-angka')
            ->call('save')
            ->assertHasErrors(['amount']);
    }

    public function test_debt_can_be_marked_as_paid(): void
    {
        $debt = Debt::factory()->create([
            'user_id' => $this->user->id,
            'is_paid' => false,
            'paid_at' => null,
        ]);

        Livewire::actingAs($this->user)
            ->test(DebtList::class)
            ->call('confirmMarkAsPaid', $debt->id)
            ->assertSet('confirmingDebtId', $debt->id)
            ->call('markAsPaid')
            ->assertSet('confirmingDebtId', null);

        $debt->refresh();

        $this->assertTrue($debt->is_paid);
        $this->assertNotNull($debt->paid_at);
    }

    public function test_debt_list_filter_active_shows_only_unpaid(): void
    {
        Debt::factory()->create([
            'user_id' => $this->user->id,
            'creditor_name' => 'Belum Bayar',
            'is_paid' => false,
        ]);

        Debt::factory()->create([
            'user_id' => $this->user->id,
            'creditor_name' => 'Sudah Bayar',
            'is_paid' => true,
        ]);

        Livewire::actingAs($this->user)
            ->test(DebtList::class)
            ->set('filter', 'active')
            ->assertSee('Belum Bayar')
            ->assertDontSee('Sudah Bayar');
    }

    public function test_debt_list_filter_paid_shows_only_paid(): void
    {
        Debt::factory()->create([
            'user_id' => $this->user->id,
            'creditor_name' => 'Belum Bayar',
            'is_paid' => false,
        ]);

        Debt::factory()->create([
            'user_id' => $this->user->id,
            'creditor_name' => 'Sudah Bayar',
            'is_paid' => true,
        ]);

        Livewire::actingAs($this->user)
            ->test(DebtList::class)
            ->set('filter', 'paid')
            ->assertSee('Sudah Bayar')
            ->assertDontSee('Belum Bayar');
    }
}
