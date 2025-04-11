<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'middle_initial' => 'A',
                'extension' => 'Jr.',
                'gender' => 'Male',
                'birth_date' => '1995-06-15',
                'email' => 'johndoe@example.com',
                'phone_number' => '1234567890',
                'year_level' => 'Senior',
                'student_id' => 'S12345',
                'campus_id' => 1,
                'college_id' => 1,
                'program_id' => 1,
                'program_major_id' => null,
                'username' => 'johndoe',
                'password' => Hash::make('password123'),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'middle_initial' => 'B',
                'extension' => null,
                'gender' => 'Female',
                'birth_date' => '1998-03-22',
                'email' => 'janesmith@example.com',
                'phone_number' => '0987654321',
                'year_level' => 'Junior',
                'student_id' => 'S67890',
                'campus_id' => 2,
                'college_id' => 2,
                'program_id' => 2,
                'program_major_id' => 1,
                'username' => 'janesmith',
                'password' => Hash::make('password123'),
            ],

        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
