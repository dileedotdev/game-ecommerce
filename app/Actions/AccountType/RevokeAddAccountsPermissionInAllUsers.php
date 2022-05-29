<?php

namespace App\Actions\AccountType;

use App\Models\AccountType;
use App\Models\User;
use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class RevokeAddAccountsPermissionInAllUsers
{
    use AsAction;

    public function handle(AccountType $accountType): void
    {
        DB::transaction(function () use ($accountType): void {
            User::permission('account_types.add_accounts.'.$accountType->getKey())
                ->get()
                ->each
                ->revokePermissionTo('account_types.add_accounts.'.$accountType->getKey())
            ;
        });
    }
}
