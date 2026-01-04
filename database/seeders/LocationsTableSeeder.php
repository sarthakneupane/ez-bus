<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Biratnagar',
            'Bhadrapur',
            'Dharan',
            'Itahari',
            'Kathmandu',
            'Pokhara'
        ];

        foreach ($locations as $location) {
            DB::table('locations')->insert([
                'name' => $location,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
