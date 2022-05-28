<?php

namespace App\Policies;

use App\Models\AccountType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('account_types.view.*');
    }

    public function view(User $user, AccountType $accountType): bool
    {
        return $user->hasPermissionTo('account_types.view.'.$accountType->getKey());
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('account_types.create');
    }

    public function addAccount(User $user, AccountType $accountType): bool
    {
        return $user->hasPermissionTo('account_types.add_accounts.'.$accountType->getKey());
    }

    public function update(User $user, AccountType $accountType): bool
    {
        return $user->hasPermissionTo('account_types.update.'.$accountType->getKey());
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('account_types.delete.*');
    }

    public function delete(User $user, AccountType $accountType): bool
    {
        return $user->hasPermissionTo('account_types.delete.'.$accountType->getKey());
    }
}
