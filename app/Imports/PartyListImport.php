<?php

namespace App\Imports;


use App\Models\PartyList;
use Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PartyListImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    private $rowCount = 0;
    private $currentRow = 0;

    public function model(array $row): ?PartyList
    {
        $this->currentRow++;

        // Skip row 2 (the sample row)
        if ($this->currentRow == 1) {
            return null;
        }
        // Normalize headers to lowercase
        $normalized = array_change_key_case($row, CASE_LOWER);

        Log::debug('Processing row', ['normalized_data' => $normalized]);


        $this->rowCount++;

        return new PartyList([
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
            'name' => 'required|string|max:255|unique:party_lists,name',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'name.required' => 'The party list name is required',
            'name.unique' => 'A party list with this name already exists',
        ];
    }

}
