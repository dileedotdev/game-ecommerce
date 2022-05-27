<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    public function up(): void
    {
        /** @var Role */
        $role = Role::findByName('admin');

        $role->givePermissionTo(
            Permission::create(['name' => 'account_types.view.*', 'description' => 'Can view any account types (include important infos)']),
            Permission::create(['name' => 'account_types.create.*', 'description' => 'Can create account types']),
            Permission::create(['name' => 'account_types.update.*', 'description' => 'Can update any account types and any related accounts']),
            Permission::create(['name' => 'account_types.delete.*', 'description' => 'Can delete any account types']),
        );
    }

    public function down(): void
    {
    }
};
