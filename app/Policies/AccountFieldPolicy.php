<?php

namespace App\Policies;

use App\Models\AccountField;
use App\Models\AccountType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountFieldPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, AccountField $accountField): bool
    {
        return $user->can('view', $accountField->type);
    }

    public function create(User $user, AccountType $accountType): bool
    {
        return $user->can('update', $accountType);
    }

    public function update(User $user, AccountField $accountField): bool
    {
        return $user->can('update', $accountField->type);
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function delete(User $user, AccountField $accountField): bool
    {
        return $user->can('update', $accountField->type);
    }
}
