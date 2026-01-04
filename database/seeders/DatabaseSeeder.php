<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            BusCompaniesTableSeeder::class,
            VehicleTypesTableSeeder::class,
            VehicleClassesTableSeeder::class,
            LocationsTableSeeder::class,
            RoutesTableSeeder::class,
            SeatFormatsTableSeeder::class,
            VehiclesTableSeeder::class,
            VehicleTypeClassSeeder::class,
            VehicleHasRoutesSeeder::class,
        ]);
    }

}
