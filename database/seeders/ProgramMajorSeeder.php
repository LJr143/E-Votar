<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramMajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $program_majors = [
            ['program_id' => 1, 'name' => 'Information Security'],
            ['program_id' => 5, 'name' => 'Filipino'],
            ['program_id' => 5, 'name' => 'English'],
            ['program_id' => 5, 'name' => 'Math'],
            ['program_id' => 3, 'name' => 'Agricultural Crop Production'],
            ['program_id' => 3, 'name' => 'Animal Production'],
        ];
        DB::table('program_majors')->insert($program_majors);
    }
}
