<?php

namespace App\Imports;

use App\Models\Council;
use App\Models\election_type;
use Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CouncilImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    private $rowCount = 0;
    private $currentRow = 0;

    public function model(array $row): ?Council
    {
        $this->currentRow++;

        // Skip row 2 (the sample row)
        if ($this->currentRow == 1 || $this->currentRow == 2 || $this->currentRow == 3) {
            return null;
        }
        // Normalize headers to lowercase
        $normalized = array_change_key_case($row, CASE_LOWER);

        Log::debug('Processing row', ['normalized_data' => $normalized]);


        $this->rowCount++;

        return new Council([
            'name' => $normalized['name'],
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:councils,name',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'name.required' => 'The position name is required',
            'name.unique' => 'A position with this name already exists',
        ];
    }

}
