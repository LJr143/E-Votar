<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\Importable;

class ImportVerification implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;

    private $rowCount = 0;

    public function model(array $row)
    {
        $row = $this->normalizeAndValidateRow($row);

        if (!is_array($row)) {
            Log::warning('Row is not an array', ['row' => $row]);
            return null;
        }

        $studentId = array_key_exists('student_id', $row) ? $row['student_id'] : null;
        $email = array_key_exists('email', $row) ? $row['email'] : null;

        // Abort if both are missing
        if (empty($studentId) && empty($email)) {
            Log::warning('Skipping row due to missing student_id and email', ['row' => $row]);
            return null;
        }

        $user = $this->findUser($studentId, $email);

        if (!$user) {
            Log::warning('User not found during verification import', ['row' => $row]);
            return null;
        }

        $user->update([
            'is_verified' => 1,
            'verified_at' => Carbon::now(),
            'verified_by' => auth()->id(),
            'verification_expires_at' => Carbon::now()->addYear(),
        ]);

        $this->rowCount++;

        return $user;
    }

    protected function normalizeAndValidateRow(array $row): ?array
    {
        try {
            if (!is_array($row)) {
                throw new \InvalidArgumentException('Row is not an array');
            }

            $normalized = [];

            foreach ($row as $key => $value) {
                // Debug: log raw key-value types
                Log::debug('Row entry', ['key' => $key, 'type' => gettype($key), 'value' => $value]);

                if (!is_string($key)) {
                    continue;
                }
                $normalized[strtolower(trim($key))] = $value;
            }

            return $normalized;
        } catch (\Exception $e) {
            Log::error('Row normalization failed', [
                'error' => $e->getMessage(),
                'row' => $row,
            ]);
            return null;
        }
    }

    protected function findUser(?string $studentId, ?string $email): ?User
    {
        $studentId = $studentId ? trim($studentId) : null;
        $email = $email ? trim(strtolower($email)) : null;

        $query = User::query();

        if ($studentId) {
            $query->where(function($q) use ($studentId) {
                $matchingIds = User::searchEncrypted($studentId, ['student_id'])
                    ->pluck('id')
                    ->toArray();

                $q->whereIn('id', $matchingIds);
            });
        }

        if ($email) {
            $query->orWhere(function($q) use ($email) {
                $matchingIds = User::searchEncrypted($email, ['email'])
                    ->pluck('id')
                    ->toArray();

                $q->whereIn('id', $matchingIds);
            });
        }

        return $query->first();
    }

    public function prepareForValidation(array $data): array
    {
        return array_merge([
            'student_id' => null,
            'email' => null,
        ], array_change_key_case($data, CASE_LOWER));
    }

    public function rules(): array
    {
        return [
            'student_id' => 'nullable|string',
            'email' => 'nullable|email',
        ];
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
