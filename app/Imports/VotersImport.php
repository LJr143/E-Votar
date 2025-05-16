<?php

namespace App\Imports;

use App\Models\Campus;
use App\Models\College;
use App\Models\Program;
use App\Models\program_major;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class VotersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures, Importable;

    private $rowCount = 0;
    private $currentRow = 0;

    /**
     * @throws Exception
     */
    public function model(array $row): ?User
    {
        $this->currentRow++;

        $normalized = array_change_key_case($row, CASE_LOWER);

        $requiredFields = ['first_name', 'last_name', 'email', 'campus', 'college', 'program'];

        foreach ($requiredFields as $field) {
            if (empty($normalized[$field])) {
                $message = "Required field '{$field}' is missing or empty in row {$this->currentRow}";
                throw new Exception($message);
            }
        }

        $campus = Campus::where('name', $normalized['campus'])->first();
        if (!$campus) {
            $message = "Campus '{$normalized['campus']}' not found (Row {$this->currentRow})";
            throw new Exception($message);
        }

        $college = College::where('name', $normalized['college'])->first();
        if (!$college) {
            $message = "College '{$normalized['college']}' not found (Row {$this->currentRow})";
            throw new Exception($message);
        }

        $program = Program::where('name', $normalized['program'])->first();
        if (!$program) {
            $message = "Program '{$normalized['program']}' not found (Row {$this->currentRow})";
            throw new Exception($message);
        }

        $major = null;
        if (!empty($normalized['program_major'])) {
            $major = program_major::where('name', $normalized['program_major'])->first();
            if (!$major) {
                $message = "Major '{$normalized['program_major']}' not found (Row {$this->currentRow})";
                throw new Exception($message);
            }
        }

        $this->rowCount++;

        Log::info("Row {$this->currentRow} - Successfully processed");

        $user = new User([
            'first_name'        => $normalized['first_name'],
            'last_name'         => $normalized['last_name'],
            'middle_initial'    => $normalized['middle_initial'] ?? null,
            'extension'         => $normalized['extension'] ?? null,
            'gender'            => $normalized['gender'] ?? null,
            'birth_date'        => $this->parseBirthDate($row['birth_date'] ?? null),
            'email'             => $normalized['email'],
            'phone_number'      => $this->formatPhoneNumber($normalized['phone_number'] ?? null),
            'year_level'        => $normalized['year_level'] ?? null,
            'student_id'        => $normalized['student_id'] ?? null,
            'campus_id'         => $campus->id,
            'college_id'        => $college->id,
            'program_id'        => $program->id,
            'program_major_id'  => $major->id ?? null,
            'account_status' => 'Pending Verification',
            'username'          => $normalized['email'],
            'password'          => Hash::make($normalized['student_id']),
        ]);

        $user->save();

        // ✅ Assign role after saving
        $user->assignRole('voter');

        return $user;
    }


    /**
     * Parse birthdate from various Excel formats
     */
    protected function parseBirthDate($dateValue): ?string
    {
        if (empty($dateValue)) {
            return null;
        }

        try {
            // Handle Excel date serial numbers
            if (is_numeric($dateValue)) {
                $date = Date::excelToDateTimeObject($dateValue);
                if ($date instanceof \DateTime) {
                    return $date->format('Y-m-d');
                }
                throw new Exception("Invalid Excel serial date: {$dateValue}");
            }

            // Normalize date string (trim whitespace, replace multiple slashes, etc.)
            $dateValue = trim($dateValue);
            $dateValue = preg_replace('/[\s]+/', '', $dateValue); // Remove extra spaces
            $dateValue = preg_replace('/\/+/', '/', $dateValue); // Normalize slashes

            // Try common date formats
            $formats = [
                'Y-m-d',        // 2004-04-03
                'm/d/Y',        // 04/03/2004
                'd/m/Y',        // 03/04/2004
                'n/j/Y',        // 4/3/2004
                'Y/m/d',        // 2004/04/03
                'm-d-Y',        // 04-03-2004
            ];

            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $dateValue);
                    if ($date && $date->isValid()) {
                        return $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            throw new Exception("Invalid date format: '{$dateValue}'. Expected formats: YYYY-MM-DD, MM/DD/YYYY, or DD/MM/YYYY.");
        } catch (\Exception $e) {
            Log::warning("Failed to parse birth date in row {$this->currentRow}: {$dateValue}. Error: {$e->getMessage()}");
            throw new Exception("Invalid date format in row {$this->currentRow}: '{$dateValue}'. Expected formats: YYYY-MM-DD, MM/DD/YYYY, DD/MM/YYYY, or valid Excel serial number.");
        }
    }

    /**
     * Format phone number preserving leading zeros
     */
    protected function formatPhoneNumber($phoneValue): ?string
    {
        if (empty($phoneValue)) {
            return null;
        }

        // Remove all non-digit characters
        $digits = preg_replace('/[^0-9]/', '', $phoneValue);

        // Handle cases where Excel stripped leading zero
        if (!empty($digits) && !str_starts_with($digits, '0') && strlen($digits) === 10) {
            $digits = '0' . $digits;
        }

        // Validate length
        if (strlen($digits) < 10) {
            throw new Exception("Phone number must be at least 10 digits");
        }

        return $digits;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|unique:users,email',
            'campus' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Campus::where('name', $value)->exists()) {
                        $fail("The selected campus is invalid.");
                    }
                }
            ],
            'college' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!College::where('name', $value)->exists()) {
                        $fail("The selected college is invalid.");
                    }
                }
            ],
            'program' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Program::where('name', $value)->exists()) {
                        $fail("The selected program is invalid.");
                    }
                }
            ],
            'program_major' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !program_major::where('name', $value)->exists()) {
                        $fail("The selected major is invalid.");
                    }
                }
            ],
            'birth_date' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($value)) {
                        try {
                            $this->parseBirthDate($value);
                        } catch (\Exception $e) {
                            $fail("Invalid date format in row {$this->currentRow}: '{$value}'. Expected formats: YYYY-MM-DD, MM/DD/YYYY, DD/MM/YYYY, or valid Excel serial number.");
                        }
                    }
                }
            ],
            'phone_number' => 'nullable|regex:/^[0-9]{10,12}$/',
            'student_id' => 'nullable|string|unique:users,student_id',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'This email already exists',
            'campus.required' => 'Campus is required',
            'college.required' => 'College is required',
            'program.required' => 'Program is required',
            'phone_number.min' => 'Phone number must be at least 10 digits',
            'student_id.unique' => 'This student ID already exists',
        ];
    }
}
