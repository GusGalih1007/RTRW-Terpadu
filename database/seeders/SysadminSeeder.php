<?php

namespace Database\Seeders;

use App\Enums\UserRoleOption;
use App\Enums\UserStatusOption;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class SysadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Users::create([
            'username' => 'Gusti SYSAdmin',
            'nik' => '1234567890123456',
            'phone' => '088214223303',
            'email' => 'gustimuhammadgalih@gmail.com',
            'password' => Crypt::encryptString('12345678'),
            'roleId' => UserRoleOption::SYSAdmin->getUuid(),
            'status' => UserStatusOption::Active->value,
            'roleVerifiedAt' => now(),
            'roleVerifiedBy' => null,
            'appointedAt' => now(),
            'appointedBy' => null,
            'alamatDetail' => null,
            'rtRwId' => null,
            'pekerjaan' => 'App Manajer',
            'anggotaKeluarga' => null,
            'email_verified_at' => now(),
            'qrImage' => null,
            'createdBy' => null,
        ]);
    }
}
