<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\constants\Roles;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => Roles::ADMIN, 'name' => 'Admin'],
            ['id' => Roles::DOCTOR, 'name' => 'Doctor'],
            ['id' => Roles::PATIENT, 'name' => 'Patient'],
            ['id' => Roles::SUPER_ADMIN, 'name' => 'Super Admin'], // Added super-admin role
        ]);
    }
}
