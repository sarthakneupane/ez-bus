<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Admin
            [
                'name' => 'System Admin',
                'email' => 'admin@example.com',
                'phone' => '9800000000',
                'address' => 'Biratnagar, Nepal',
                'role' => '0',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Bus Company 1
            [
                'name' => 'Himalaya Bus Company',
                'email' => 'company1@example.com',
                'phone' => '9811111111',
                'address' => 'Kathmandu, Nepal',
                'role' => '1',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Bus Company 2
            [
                'name' => 'Everest Bus Company',
                'email' => 'company2@example.com',
                'phone' => '9822222222',
                'address' => 'Pokhara, Nepal',
                'role' => '1',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // User 1
            [
                'name' => 'Sarthak Neupane',
                'email' => 'user1@example.com',
                'phone' => '9833333333',
                'address' => 'Lalitpur, Nepal',
                'role' => '2',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // User 2
            [
                'name' => 'Normal User',
                'email' => 'user2@example.com',
                'phone' => '9844444444',
                'address' => 'Dharan, Nepal',
                'role' => '2',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
