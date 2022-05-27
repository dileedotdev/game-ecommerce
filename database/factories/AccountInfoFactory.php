<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountField;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountInfo>
 */
class AccountInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'account_field_id' => AccountField::factory(),
            'value' => Str::random(),
        ];
    }
}
