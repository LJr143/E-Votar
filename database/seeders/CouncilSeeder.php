<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouncilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $council = [
            [ 'name' => 'Society of Information Technology Students'],
            [ 'name' => 'Society of Agricultural and Bio-systems Engineering'],
            [ 'name' => 'Association of Future Secondary Education Teachers'],
            [ 'name' => 'Association of Early Childhood Education Students'],
            [ 'name' => 'Future Technical Vocational Education Teachers'],
            [ 'name' => 'Organization of Future Special Needs Education Teachers'],
            [ 'name' => 'Organization of Future Elementary Education Teachers'],

        ];

        DB::table('councils')->insert($council);
    }
}
