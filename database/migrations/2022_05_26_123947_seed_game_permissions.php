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
            Permission::create(['name' => 'games.view.*', 'description' => 'Can view any games (include important infos)']),
            Permission::create(['name' => 'games.create', 'description' => 'Can create games']),
            Permission::create(['name' => 'games.update.*', 'description' => 'Can update any games']),
            Permission::create(['name' => 'games.delete.*', 'description' => 'Can delete any games']),
        );
    }

    public function down(): void
    {
    }
};
