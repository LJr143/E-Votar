<?php

namespace Database\Seeders;

use App\Models\Election_Type;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CampusSeeder::class,
            CollegeSeeder::class,
            ProgramSeeder::class,
            ProgramMajorSeeder::class,
            ElectionTypeSeeder::class,
            PositionSeeder::class,
            PartyListSeeder::class,
        ]);

    }
}
