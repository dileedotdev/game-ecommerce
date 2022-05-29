<?php

namespace App\Actions\Account;

use App\Models\AccountInfo;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateInfo
{
    use AsAction;

    public function handle(
        AccountInfo $accountInfo,
        string $value,
    ): void {
        $result = $accountInfo->forceFill([
            'value' => $value,
        ])->save();

        if (!$result) {
            throw new \Exception('Failed to update account info');
        }
    }
}
