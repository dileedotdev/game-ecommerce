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
            Permission::create(['name' => 'users.update_balance.*', 'description' => 'Can update balance in any users']),
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
