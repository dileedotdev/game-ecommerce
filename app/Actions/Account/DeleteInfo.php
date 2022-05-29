<?php

namespace App\Actions\Account;

use App\Models\AccountInfo;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteInfo
{
    use AsAction;

    public function handle(AccountInfo $accountInfo): void
    {
        $result = $accountInfo->delete();

        if (!$result) {
            throw new \Exception('Failed to delete account info');
        }
    }
}
