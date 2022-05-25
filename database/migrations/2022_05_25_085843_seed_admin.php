<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var User */
        $admin = User::whereEmail('dinhdjj@gmail.com')
            ->firstOr(fn () => User::forceCreate([
                'name' => 'Le Dinh',
                'login' => 'dinhdjj',
                'email' => 'dinhdjj@gmail.com',
                'password' => Hash::make('password'),
            ]))
        ;

        $role = Role::create(['name' => 'admin']);

        $admin->assignRole($role);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
