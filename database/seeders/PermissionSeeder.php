<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'users view',
            'users create',
            'users update',
            'users delete',
        ];
        $roles = [
            'roles view',
            'roles create',
            'roles update',
            'roles delete',
        ];

        $klasifikasi = [
            'klasifikasi view',
            'klasifikasi create',
            'klasifikasi update',
            'klasifikasi delete',
        ];

        $kepala = [
            "kepala bidang",
            "kepala dinas"
        ];

        $aduan = [
            'aduan view',
            // 'aduan create',
            'aduan update',
            'aduan direct',
            'aduan reject',
            'aduan accept',
            'aduan continue',
            'aduan delete',

        ];

        $allPermissions = array_merge($users, $roles, $klasifikasi, $kepala, $aduan);

        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
