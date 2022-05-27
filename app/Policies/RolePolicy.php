<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('roles.view');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasPermissionTo("roles.view.{$role->getKey()}");
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('roles.create');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasPermissionTo("roles.update.{$role->getKey()}");
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('roles.delete');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasPermissionTo("roles.delete.{$role->getKey()}");
    }
}
