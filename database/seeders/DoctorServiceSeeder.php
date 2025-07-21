<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Service;

class DoctorServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();

        Doctor::all()->each(function ($doctor) use ($services) {
            // Attach 1 to 3 random services to each doctor
            $randomServices = $services->random(rand(1, 3))->pluck('id')->toArray();
            $doctor->services()->sync($randomServices);
        });
    }
}
