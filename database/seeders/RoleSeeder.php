<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'roleName' => 'SYSAdmin',
            'description' => 'System Admin'
        ]);
        Role::create([
            'roleName' => 'Admin',
            'description' => 'Ketua Kelurahan'
        ]);
        Role::create([
            'roleName' => 'Sub-Admin',
            'description' => 'Ketua RT/RW'
        ]);
        Role::create([
            'roleName' => 'User',
            'description' => 'Warga'
        ]);
        Role::create([
            'roleName' => 'Staff',
            'description' => 'Petugas pilihan RT/RW'
        ]);
    }
}
