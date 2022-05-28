<?php

namespace App\Actions\Permission;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class Delete
{
    use AsAction;

    public function handle(string|Permission|Collection $permissions, string $guard = null): void
    {
        if (\is_string($permissions)) {
            $permissions = collect([Permission::findByName($permissions, $guard)]);
        } elseif ($permissions instanceof Permission) {
            $permissions = collect([$permissions]);
        }

        $permissions->each->delete();
    }
}
