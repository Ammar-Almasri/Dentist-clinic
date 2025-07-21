<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Teeth Cleaning', 'price' => 25.00, 'duration' => 30],
            ['name' => 'Cavity Filling', 'price' => 50.00, 'duration' => 45],
            ['name' => 'Braces Consultation', 'price' => 40.00, 'duration' => 60],
            ['name' => 'Whitening', 'price' => 100.00, 'duration' => 45],
            ['name' => 'Tooth Extraction', 'price' => 75.00, 'duration' => 30],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
