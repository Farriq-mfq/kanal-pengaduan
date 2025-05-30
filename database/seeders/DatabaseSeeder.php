<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'jabatan' => 'SuperAdmin',
            'password' => bcrypt('admin'),
        ]);


        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class
        ]);

        // all permissions
        $permissios = Permission::all();

        // primary role
        $role = Role::where('name', 'superAdmin')->first();
        $role->givePermissionTo($permissios);
        $user->assignRole($role);

    }
}
