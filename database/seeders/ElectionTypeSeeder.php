<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $election_types = [
            ['name' => 'Student and Local Council Election'],
            ['name'=> 'Student Council Election'],
            ['name'=> 'Local Council Election'],
            ['name'=> 'Special Election'],
            ];

        DB::table('election_types')->insert($election_types);
    }
}
