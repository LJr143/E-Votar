<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartyListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partyList = [
            ['name' => 'Yanong Agila'],
            ['name' => 'Paragon'],
        ];

        DB::table('party_lists')->insert($partyList);
    }
}
