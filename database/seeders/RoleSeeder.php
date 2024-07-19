<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_user = Role::create(['name' => 'user']);

        $user_admin = User::find(1);
        $user_admin->assignRole($role_admin);

        $user_user = User::find(2);
        $user_user->assignRole($role_user);
    }
}
