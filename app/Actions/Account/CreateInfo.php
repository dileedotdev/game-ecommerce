<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountInfo;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateInfo
{
    use AsAction;

    public function handle(
        Account $account,
        AccountField $accountField,
        string $value,
    ): AccountInfo {
        return AccountInfo::forceCreate([
            'account_id' => $account->id,
            'account_field_id' => $accountField->id,
            'value' => $value,
        ]);
    }
}
