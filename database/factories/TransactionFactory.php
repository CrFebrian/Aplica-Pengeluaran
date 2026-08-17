<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['income', 'expense']);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory()->state(['type' => $type]),
            'title' => \Illuminate\Support\Str::limit(fake()->sentence(3), 50, ''),
            'amount' => fake()->numberBetween(10000, 2000000),
            'type' => $type,
            'transaction_date' => fake()->dateTimeBetween('-2 months', 'now'),
            'note' => fake()->optional()->sentence(),
        ];
    }
}