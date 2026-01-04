<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VehicleTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Bus', 'Micro Bus', 'Jeep'];

        foreach ($types as $type) {
            DB::table('vehicle_types')->insert([
                'name' => $type,
                'slug' => Str::slug($type),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
