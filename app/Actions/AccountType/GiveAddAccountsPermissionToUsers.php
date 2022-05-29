<?php

namespace App\Actions\AccountType;

use App\Models\AccountType;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GiveAddAccountsPermissionToUsers
{
    use AsAction;

    public function handle(AccountType $accountType, User|Collection $users): void
    {
        if ($users instanceof User) {
            $users = collect([$users]);
        }

        DB::transaction(function () use ($accountType, $users): void {
            $users->each->givePermissionTo("account_types.add_accounts.{$accountType->getKey()}");
        });
    }
}
