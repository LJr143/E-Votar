<?php
namespace App\Imports;

use App\Models\election_type;
use App\Models\Position;
use Exception;
use Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class PositionImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures, Importable;

    private $rowCount = 0;
    private $currentRow = 0;


    /**
     * @throws Exception
     */
    public function model(array $row): ?Position
    {
        $this->currentRow++;

        // Skip row 2 (the sample row)
        if ($this->currentRow === 2) {
            return null;
        }
        // Normalize headers to lowercase
        $normalized = array_change_key_case($row, CASE_LOWER);

        Log::debug('Processing row', ['normalized_data' => $normalized]);

        $councilType = $normalized['council_type'] ?? null;

        if (!$councilType) {
            throw new \Exception("Council type field not found in import file");
        }

        $electionType = election_type::where('name', $councilType)->first();

        if (!$electionType) {
            throw new \Exception("Election type '{$councilType}' not found");
        }

        $this->rowCount++;

        return new Position([
            'name' => $normalized['name'],
            'num_winners' => $normalized['num_winners'],
            'election_type_id' => $electionType->id,
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:positions,name',
            'council_type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!election_type::where('name', $value)->exists()) {
                        $fail("The selected council type is invalid.");
                    }
                }
            ],
            'num_winners' => 'required|integer|min:1',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'name.required' => 'The position name is required',
            'name.unique' => 'A position with this name already exists',
            'council_type.required' => 'The council type is required',
            'num_winners.required' => 'The number of winners is required',
            'num_winners.min' => 'There must be at least 1 winner',
        ];
    }
}
