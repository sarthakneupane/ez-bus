<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatFormatsTableSeeder extends Seeder
{
    public function run(): void
    {
        $formats = [
            ['column_left' => 2, 'column_right' => 2, 'rows' => 10], // Standard 2x2
            ['column_left' => 1, 'column_right' => 2, 'rows' => 8],  // Mini bus 1x2
            ['column_left' => 2, 'column_right' => 1, 'rows' => 12], // Custom 2x1
        ];

        foreach ($formats as $format) {
            DB::table('seat_formats')->insert([
                'column_left' => $format['column_left'],
                'column_right' => $format['column_right'],
                'rows' => $format['rows'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
