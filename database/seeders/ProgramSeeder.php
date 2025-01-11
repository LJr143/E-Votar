<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            ['college_id' => 2, 'name' => 'Bachelor of Science in Information Technology'],
            ['college_id' => 3, 'name' => 'Bachelor of Science in Agricultural and Bio-systems Engineering'],
            ['college_id' => 2, 'name' => 'Bachelor of Technical-Vocation Teacher Education'],
            ['college_id' => 2, 'name' => 'Bachelor of Elementary Education'],
            ['college_id' => 2, 'name' => 'Bachelor of Secondary Education'],
            ['college_id' => 2, 'name' => 'Bachelor of Early Childhood Education'],
        ];

        DB::table('programs')->insert($programs);
    }
}
