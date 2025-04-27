<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campuses = [
            ['name' => 'Obrero Campus'],
            ['name' => 'Tagum Unit'],
            ['name' => 'Mabini Unit'],
            ['name' => 'Mintal Campus'],
            ['name' => 'Malabog Extension Campus'],
        ];

        DB::table('campuses')->insert($campuses);
    }
}
