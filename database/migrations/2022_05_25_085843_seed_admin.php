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
        $role = Role::create(['name' => 'admin', 'is_build_in' => true, 'description' => 'System Administrator']);

        $role->givePermissionTo(
            Permission::create(['name' => 'view.admin-page', 'is_build_in' => true, 'description' => 'Can view admin page']),
            Permission::create(['name' => 'permissions.view', 'is_build_in' => true, 'description' => 'Can view any permissions']),
            Permission::create(['name' => 'permissions.create', 'is_build_in' => true, 'description' => 'Can create permissions']),
            Permission::create(['name' => 'permissions.update', 'is_build_in' => true, 'description' => 'Can update any permissions']),
            Permission::create(['name' => 'permissions.delete', 'is_build_in' => true, 'description' => 'Can update delete permissions']),
            Permission::create(['name' => 'roles.view', 'is_build_in' => true, 'description' => 'Can view any roles']),
            Permission::create(['name' => 'roles.create', 'is_build_in' => true, 'description' => 'Can create roles']),
            Permission::create(['name' => 'roles.update', 'is_build_in' => true, 'description' => 'Can update any roles']),
            Permission::create(['name' => 'roles.delete', 'is_build_in' => true, 'description' => 'Can delete any roles']),
            Permission::create(['name' => 'users.view', 'is_build_in' => true, 'description' => 'Can view any users']),
            Permission::create(['name' => 'users.create', 'is_build_in' => true, 'description' => 'Can create users']),
            Permission::create(['name' => 'users.update', 'is_build_in' => true, 'description' => 'Can update any users']),
            Permission::create(['name' => 'users.delete', 'is_build_in' => true, 'description' => 'Can delete any users']),
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
