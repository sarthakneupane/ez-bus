<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleTypeClassSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['vehicle_type_id' => 1, 'vehicle_class_id' => 1, 'fare_increment' => 30], // Bus + Luxury
            ['vehicle_type_id' => 1, 'vehicle_class_id' => 2, 'fare_increment' => 15], // Bus + Business
            ['vehicle_type_id' => 2, 'vehicle_class_id' => 2, 'fare_increment' => 20], // Micro Bus + Business
            ['vehicle_type_id' => 2, 'vehicle_class_id' => 3, 'fare_increment' => 10], // Micro Bus + Economy
            ['vehicle_type_id' => 3, 'vehicle_class_id' => 3, 'fare_increment' => 50],  // Jeep + Economy
        ];

        foreach ($data as $item) {
            DB::table('vehicle_type_class')->insert([
                'vehicle_type_id' => $item['vehicle_type_id'],
                'vehicle_class_id' => $item['vehicle_class_id'],
                'fare_increment' => $item['fare_increment'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
