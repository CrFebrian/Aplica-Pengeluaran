<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DebtFactory extends Factory
{
    public function definition(): array
    {
        $isPaid = fake()->boolean(30);

        return [
            'user_id' => User::factory(),
            'creditor_name' => fake()->name(),
            'amount' => fake()->numberBetween(50000, 5000000),
            'due_date' => fake()->dateTimeBetween('now', '+3 months'),
            'is_paid' => $isPaid,
            'paid_at' => $isPaid ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'note' => fake()->optional()->sentence(),
        ];
    }
}
