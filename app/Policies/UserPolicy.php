<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('users.view');
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo("users.view.{$model->getKey()}");
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('users.create');
    }

    public function update(User $user, user $model): bool
    {
        return $user->hasPermissionTo("users.update.{$model->getKey()}");
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('users.delete');
    }

    public function delete(User $user, user $model): bool
    {
        return $user->hasPermissionTo("users.delete.{$model->getKey()}");
    }
}
