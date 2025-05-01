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
            'email' => 'admin@example.com',
            'jabatan' => 'SuperAdmin',
            'password' => bcrypt('password'),
        ]);


        $this->call([
            PermissionSeeder::class
        ]);

        // all permissions
        $permissios =  Permission::all();

        // primary role
        $role = Role::create(['name' => 'superAdmin']);
        $role->givePermissionTo($permissios);
        $user->assignRole($role);
    }
}
