<?php

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $adminData = [
            'name' => 'Admin',
            'login' => 'admin',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
        ];
        /** @var User */
        $admin = User::whereEmail('admin@admin.admin')->firstOr(fn () => User::forceCreate($adminData));
        $admin->forceFill($adminData)->save();

        /** @var Role */
        $role = Role::create(['name' => 'admin', 'description' => 'System Administrator']);

        $role->givePermissionTo(
            Permission::create(['name' => 'view.admin-page', 'description' => 'Can view admin page (important)']),
            Permission::create(['name' => 'permissions.view.*', 'description' => 'Can view any permissions (include important infos)']),
            Permission::create(['name' => 'roles.view.*', 'description' => 'Can view any roles (include important infos)']),
            Permission::create(['name' => 'roles.create.*', 'description' => 'Can create roles']),
            Permission::create(['name' => 'roles.update.*', 'description' => 'Can update any roles']),
            Permission::create(['name' => 'roles.delete.*', 'description' => 'Can delete any roles']),
            Permission::create(['name' => 'users.view.*', 'description' => 'Can view any users (include important infos)']),
            Permission::create(['name' => 'users.create.*', 'description' => 'Can create users']),
            Permission::create(['name' => 'users.update.*', 'description' => 'Can update any users']),
            Permission::create(['name' => 'users.delete.*', 'description' => 'Can delete any users']),
        );

        $admin->assignRole($role);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
