<?php

namespace App\Actions\Permission;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class Create
{
    use AsAction;

    public function handle(string $name, Model|Collection $members, string $description = null): Permission
    {
        $permission = Permission::create(['name' => $name, 'description' => $description]);

        if ($members instanceof Model) {
            $members = collect([$members]);
        }

        $members->each->givePermissionTo($permission); /** @phpstan-ignore-line */

        return $permission;
    }
}
