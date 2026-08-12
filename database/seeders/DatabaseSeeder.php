<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Debt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Kategori pemasukan
        $incomeCategories = collect(['Gaji Bulanan', 'Uang Jajan', 'Bonus', 'Freelance'])
            ->map(fn ($name) => Category::create([
                'user_id' => $user->id,
                'name' => $name,
                'type' => 'income',
            ]));

        // Kategori pengeluaran
        $expenseCategories = collect(['Makan Siang', 'Bensin', 'Belanja Bulanan', 'Hiburan', 'Tagihan Listrik'])
            ->map(fn ($name) => Category::create([
                'user_id' => $user->id,
                'name' => $name,
                'type' => 'expense',
            ]));

        // Buat 15 transaksi pengeluaran & 6 transaksi pemasukan yang saling terhubung ke kategori di atas
        $expenseCategories->each(function ($category) use ($user) {
            Transaction::factory()
                ->count(3)
                ->create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'type' => 'expense',
                ]);
        });

        $incomeCategories->each(function ($category) use ($user) {
            Transaction::factory()
                ->count(2)
                ->create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'type' => 'income',
                ]);
        });

        // Beberapa catatan hutang
        Debt::factory()
            ->count(4)
            ->create(['user_id' => $user->id]);
    }
}