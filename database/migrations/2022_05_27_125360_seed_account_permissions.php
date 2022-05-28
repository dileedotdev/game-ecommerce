<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var Role */
        $role = Role::findByName('admin');

        $role->givePermissionTo(
            Permission::create(['name' => 'accounts.view.*', 'description' => 'Can view any accounts (include important infos)']),
            Permission::create(['name' => 'accounts.update.*', 'description' => 'Can update any accounts']),
            Permission::create(['name' => 'accounts.delete.*', 'description' => 'Can delete any accounts']),
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
