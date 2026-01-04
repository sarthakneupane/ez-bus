<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleClassesTableSeeder extends Seeder
{
    public function run(): void
    {
        $classes = ['Luxury', 'Business', 'Economy'];

        foreach ($classes as $class) {
            DB::table('vehicle_classes')->insert([
                'name' => $class,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
