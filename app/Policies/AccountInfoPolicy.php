<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\AccountField;
use App\Models\AccountInfo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountInfoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, AccountInfo $accountInfo): bool
    {
        $field = $accountInfo->field;
        $account = $accountInfo->account;

        if ($field->can_view_by_anyone) {
            return true;
        }

        if (!$field->can_view_by_creator && $account->creator_id === $user->id) {
            return false;
        }

        if ($account->confirmed_at && $account->confirmed_at->lte(now())) {
            if (!$field->can_view_by_confirmed_buyer && $account->buyer_id === $user->id) {
                return false;
            }
        } else {
            if (!$field->can_view_by_unconfirmed_buyer && $account->buyer_id === $user->id) {
                return false;
            }
        }

        return $user->can('view', $accountInfo->account);
    }

    public function create(User $user, Account $account, AccountField $field): bool
    {
        if ($account->account_type_id !== $field->account_type_id) {
            return false;
        }

        if (!$field->can_create_by_creator && $account->creator_id === $user->id) {
            return false;
        }

        return $user->can('update', $account);
    }

    public function update(User $user, AccountInfo $accountInfo): bool
    {
        $field = $accountInfo->field;
        $account = $accountInfo->account;

        if (!$field->can_update_by_creator && $account->creator_id === $user->id) {
            return false;
        }

        return $user->can('update', $accountInfo->account);
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function delete(User $user, AccountInfo $accountInfo): bool
    {
        $field = $accountInfo->field;
        $account = $accountInfo->account;

        if (!$field->can_delete_by_creator && $account->creator_id === $user->id) {
            return false;
        }

        return $user->can('update', $accountInfo->account);
    }
}
