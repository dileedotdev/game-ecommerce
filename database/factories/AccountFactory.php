<?php

namespace Database\Factories;

use App\Models\AccountType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_type_id' => AccountType::factory(),
            'description' => $this->faker->sentence(),
            'creator_id' => User::factory(),
            'buyer_id' => User::factory(),
        ];
    }
}
