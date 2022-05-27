<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('accounts.view.*');
    }

    public function view(User $user, Account $account): bool
    {
        return $user->hasPermissionTo('accounts.view.'.$account->getKey());
    }

    public function create(User $user, AccountType $accountType): bool
    {
        return $user->hasPermissionTo('accounts.create.'.$accountType->getKey());
    }

    public function update(User $user, Account $account): bool
    {
        return $user->hasPermissionTo('accounts.update.'.$account->getKey());
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('accounts.delete.*');
    }

    public function delete(User $user, Account $account): bool
    {
        return $user->hasPermissionTo('accounts.delete.'.$account->getKey());
    }
}
