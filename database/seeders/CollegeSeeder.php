<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = [
            ['campus_id' => 2, 'name' => 'College of Agricultural and Bio-systems Engineering'],
            ['campus_id' => 2, 'name' => 'College of Teacher Education and Technology'],
            ['campus_id' => 2, 'name' => 'College of Engineering'],
            ['campus_id' => 1, 'name' => 'College of Engineering'],
            ['campus_id' => 1, 'name' => 'College of Information and Computing'],
        ];

        DB::table('colleges')->insert($colleges);

    }
}
