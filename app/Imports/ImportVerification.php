<?php

namespace App\Imports;

use App\Models\Campus;
use App\Models\College;
use App\Models\Program;
use App\Models\program_major;
use App\Models\ProgramMajor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\Importable;
use Throwable;

class ImportVerification implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;

    private $rowCount = 0;

    public function model(array $row)
    {
        // Normalize column names
        $row = array_change_key_case($row, CASE_LOWER);

        // Find user by student_id or email
        $user = User::where('student_id', $row['student_id'] ?? null)
            ->orWhere('email', $row['email'])
            ->first();

        $test = User::first();
        dd($test);

        // Get related models
        $campus = Campus::firstWhere('name', $row['campus']);
        $college = College::firstWhere('name', $row['college']);
        $program = Program::firstWhere('name', $row['program']);
        $major = isset($row['program_major'])
            ? program_major::firstWhere('name', $row['program_major'])
            : null;

        // Prepare user data
        $userData = [
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'middle_initial' => $row['middle_initial'] ?? null,
            'extension' => $row['extension'] ?? null,
            'gender' => $row['gender'] ?? null,
            'email' => $row['email'],
            'phone_number' => $this->formatPhoneNumber($row['phone_number'] ?? null),
            'year_level' => $row['year_level'] ?? null,
            'student_id' => $row['student_id'] ?? null,
            'campus_id' => $campus->id,
            'college_id' => $college->id,
            'program_id' => $program->id,
            'program_major_id' => $major->id ?? null,
            'account_status' => 'Pending Verification',
            'username' => $row['email'],
            'isVerified' => 1,
            'verified_at' => Carbon::now(),
            'verified_by' => auth()->id(),
            'verification_expires_at' => Carbon::now()->addYear(),
        ];

        if ($user) {
            // Update existing user
            $user->update($userData);
            $this->rowCount++;
            return $user;
        }

        // Create new user if not found
        $userData['password'] = Hash::make($row['student_id'] ?? $row['email']);
        $newUser = User::create($userData);
        $newUser->assignRole('voter');
        $this->rowCount++;

        return $newUser;
    }

    public function rules(): array
    {
        return [
            '*.first_name' => 'required|string|max:255',
            '*.last_name' => 'required|string|max:255',
            '*.email' => 'required|email',
            '*.campus' => 'required|exists:campuses,name',
            '*.college' => 'required|exists:colleges,name',
            '*.program' => 'required|exists:programs,name',
            '*.program_major' => 'nullable|exists:program_majors,name',
            '*.student_id' => 'nullable',
        ];
    }

    protected function formatPhoneNumber($phone)
    {
        if (empty($phone)) return null;
        return preg_replace('/[^0-9]/', '', $phone);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function onError(Throwable $e)
    {
        logger()->error('Import error: ' . $e->getMessage());
    }
}
