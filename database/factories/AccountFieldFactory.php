<?php

namespace Database\Factories;

use App\Models\AccountType;
use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountField>
 */
class AccountFieldFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_type_id' => AccountType::factory(),
            'name' => $this->faker->unique()->name(),
            'is_required' => $this->faker->boolean(),
            'regex' => Arr::random([null, '^[0-9]{1,}$', '^[a-zA-Z0-9]{1,}$']),
            'can_create_by_creator' => $this->faker->boolean(),
            'can_update_by_creator' => $this->faker->boolean(),
            'can_delete_by_creator' => $this->faker->boolean(),

            'can_view_by_anyone' => $this->faker->boolean(),
            'can_view_by_creator' => $this->faker->boolean(),
            'can_view_by_unconfirmed_buyer' => $this->faker->boolean(),
            'can_view_by_confirmed_buyer' => $this->faker->boolean(),
        ];
    }
}
