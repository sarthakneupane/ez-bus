<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Sample route data with fare
        $routes = [
            ['from' => 1, 'to' => 2, 'fare' => 1700], // Biratnagar -> Bhadrapur
            ['from' => 1, 'to' => 3, 'fare' => 1200], // Biratnagar -> Dharan
            ['from' => 2, 'to' => 4, 'fare' => 800],  // Bhadrapur -> Itahari
            ['from' => 3, 'to' => 4, 'fare' => 500],  // Dharan -> Itahari
            ['from' => 5, 'to' => 6, 'fare' => 2500], // Kathmandu -> Pokhara
            ['from' => 4, 'to' => 5, 'fare' => 2000], // Itahari -> Kathmandu
        ];

        foreach ($routes as $route) {
            DB::table('routes')->insert([
                'from' => $route['from'],
                'to' => $route['to'],
                'fare' => $route['fare'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
