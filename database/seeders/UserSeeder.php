<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => 'password123',
                'role' => 'admin',
                'phone' => null,
                'photo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Loket',
                'username' => 'loket',
                'password' => 'password123',
                'role' => 'petugas_loket',
                'phone' => null,
                'photo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Kutipan Kedua',
                'username' => 'kutipan_kedua',
                'password' => 'password123',
                'role' => 'kutipan_kedua',
                'phone' => null,
                'photo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Keabsahan',
                'username' => 'keabsahan',
                'password' => 'password123',
                'role' => 'keabsahan',
                'phone' => null,
                'photo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Surat Pengantar',
                'username' => 'surat_pengantar',
                'password' => 'password123',
                'role' => 'surat_pengantar',
                'phone' => null,
                'photo' => null,
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'username' => $user['username'],
                ],
                $user
            );
        }
    }
}