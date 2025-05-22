<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role_id' => 1, // đảm bảo role_id 1 là 'admin'
            ],
            [
                'name' => 'Trưởng phòng Nhân sự',
                'email' => 'truongphong@example.com',
                'role_id' => 2, // đảm bảo role_id 2 là 'truong_phong'
            ],
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'nhanvien@example.com',
                'role_id' => 3, // đảm bảo role_id 3 là 'nhan_vien'
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('123456'),
                    'role_id' => $user['role_id'],
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
