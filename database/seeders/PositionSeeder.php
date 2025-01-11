<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['election_type_id'=>2, 'name' => 'President'],
            ['election_type_id'=>2, 'name' => 'Internal Vice President'],
            ['election_type_id'=>2, 'name' => 'External Vice President'],
            ['election_type_id'=>2, 'name' => 'General Secretary'],
            ['election_type_id'=>2, 'name' => 'General Treasurer'],
            ['election_type_id'=>2, 'name' => 'Public Information Officer'],
            ['election_type_id'=>3, 'name' => 'Governor'],
            ['election_type_id'=>3, 'name' => 'Vice Governor'],
            ['election_type_id'=>3, 'name' => 'Secretary'],
            ['election_type_id'=>3, 'name' => 'Treasurer'],
            ['election_type_id'=>3, 'name' => 'Auditor'],
            ['election_type_id'=>3, 'name' => 'Senator'],
            ['election_type_id'=>3, 'name' => 'Senator'],
            ['election_type_id'=>3, 'name' => 'Senator'],

        ];

        DB::table('positions')->insert($positions);
    }
}
