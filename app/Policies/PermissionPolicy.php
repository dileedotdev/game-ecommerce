<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('permissions.view');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo("permissions.view.{$permission->getKey()}");
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('permissions.create');
    }

    public function update(User $user, Permission $permission): bool
    {
        if ($permission->is_build_in) {
            return false;
        }

        return $user->hasPermissionTo("permissions.update.{$permission->getKey()}");
    }

    public function deleteAny(): bool
    {
        return false;
    }

    public function delete(User $user, Permission $permission): bool
    {
        if ($permission->is_build_in) {
            return false;
        }

        return $user->hasPermissionTo("permissions.delete.{$permission->getKey()}");
    }
}
