<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bus_companies')->insert([
            [
                'user_id' => 2, // User ID of Himalaya Bus Company
                'bc_name' => 'Himalaya Bus Company',
                'no_of_bus' => 10,
                'status' => '1', // active
                'company_registration' => 'uploads/company_registration/himalaya.pdf',
                'cover_letter' => 'uploads/cover_letters/himalaya_letter.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // User ID of Everest Bus Company
                'bc_name' => 'Everest Bus Company',
                'no_of_bus' => 8,
                'status' => '1', // active
                'company_registration' => 'uploads/company_registration/everest.pdf',
                'cover_letter' => 'uploads/cover_letters/everest_letter.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
