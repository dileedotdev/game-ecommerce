<?php

namespace App\Actions\AccountType;

use App\Models\AccountType;
use Lorisleiva\Actions\Concerns\AsAction;

class Update
{
    use AsAction;

    public function handle(AccountType $accountType, string $name, ?string $description = null): void
    {
        $result = $accountType->forceFill([
            'name' => $name,
            'description' => $description,
        ])->save();

        if (!$result) {
            throw new \Exception('Cannot update account type');
        }
    }
}
