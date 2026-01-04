<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiclesTableSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'bus_company_id' => 1,  // Himalaya Bus Company
                'vehicle_no' => 'BAA-1234',
                'vehicle_type_id' => 1, // Bus
                'vehicle_class_id' => 1, // Luxury
                'amenities' => 'AC, WiFi, Blanket',
                'seat_formats_id' => 1, // 2x2
                'registration_pdf' => 'uploads/vehicle_registration/baa-1234.pdf',
                'image' => 'uploads/vehicles/baa-1234.jpg',
            ],
            [
                'bus_company_id' => 2,  // Everest Bus Company
                'vehicle_no' => 'BAA-5678',
                'vehicle_type_id' => 2, // Micro Bus
                'vehicle_class_id' => 2, // Business
                'amenities' => 'AC, Charger',
                'seat_formats_id' => 2, // 1x2
                'registration_pdf' => 'uploads/vehicle_registration/baa-5678.pdf',
                'image' => 'uploads/vehicles/baa-5678.jpg',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            DB::table('vehicles')->insert([
                'bus_company_id' => $vehicle['bus_company_id'],
                'vehicle_no' => $vehicle['vehicle_no'],
                'vehicle_type_id' => $vehicle['vehicle_type_id'],
                'vehicle_class_id' => $vehicle['vehicle_class_id'],
                'amenities' => $vehicle['amenities'],
                'seat_formats_id' => $vehicle['seat_formats_id'],
                'registration_pdf' => $vehicle['registration_pdf'],
                'image' => $vehicle['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
