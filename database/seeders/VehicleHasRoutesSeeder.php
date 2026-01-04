<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleHasRoutesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['vehicle_id' => 1, 'route_id' => 1], // Himalaya Bus -> Biratnagar to Bhadrapur
            ['vehicle_id' => 1, 'route_id' => 2], // Himalaya Bus -> Biratnagar to Dharan
            ['vehicle_id' => 2, 'route_id' => 4], // Everest Micro Bus -> Dharan to Itahari
            ['vehicle_id' => 2, 'route_id' => 5], // Everest Micro Bus -> Kathmandu to Pokhara
        ];

        foreach ($data as $item) {
            DB::table('vehicle_has_routes')->insert([
                'vehicle_id' => $item['vehicle_id'],
                'route_id' => $item['route_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
