<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Constants\Roles;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'phone' => '0790000001',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => Roles::ADMIN,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Doctor User',
                'phone' => '0790000002',
                'email' => 'doctor@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => Roles::DOCTOR,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Patient User',
                'phone' => '0790000003',
                'email' => 'patient@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => Roles::PATIENT,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
