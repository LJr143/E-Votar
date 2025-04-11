<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voterRole = Role::where('name', 'voter')->first();
        User::factory(162)->create()->each(function ($user) use ($voterRole) {
            $user->assignRole($voterRole);
        });
    }
}
