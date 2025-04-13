<?php
namespace App\Livewire\ManageVoter;

use App\Exports\PartyListExport;
use App\Exports\VoterExport;
use App\Imports\VotersImport;
use App\Models\Campus;
use App\Models\College;
use App\Models\Program;
use App\Models\program_major;
use App\Models\User;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class VoterTable extends Component
{
    use WithPagination, WithFileUploads;
    protected $listeners  = ['voter-updated' => '$refresh', 'deactivated-user' => '$refresh', 'activated-user' => '$refresh'];

//    public string $filter = 'all_users';
    public string $search = '';
    public $perPage = 10;

    public $importFile;
    public $importing = false;
    public $importErrors = [];
    public $importError = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

//    public function updatingFilter(): void
//    {
//        $this->resetPage();
//    }
//
//    public function setFilter(string $filter): void
//    {
//        $this->filter = $filter;
//        $this->resetPage();
//    }

    public function resetImport(): void
    {
        $this->reset(['importing', 'importError', 'importErrors', 'importFile']);
    }


    public function fetchUsers()
    {
        $usersQuery = User::whereHas('roles', function ($q) {
            $q->where('name', 'voter');
        })
            ->orderBy('id', 'desc')
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%');
            });

        if ($this->perPage === 'all') {
            return $usersQuery->get();
        } else {
            return $usersQuery->paginate($this->perPage);
        }

    }
    public function downloadExcelFormat(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Path to your template file
        $templatePath = public_path('templates/voter_import_template.xlsx');

        // Check if file exists
        if (!file_exists($templatePath)) {
            // Create a default template if it doesn't exist
            $this->createDefaultTemplate();
        }

        return response()->download($templatePath, 'voter_import_template.xlsx');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    protected function createDefaultTemplate(): void
    {
        $templatePath = public_path('templates/voter_import_template.xlsx');

        // Create directory if it doesn't exist
        if (!is_dir(dirname($templatePath))) {
            mkdir(dirname($templatePath), 0755, true);
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define styles (same as before)
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EA153D']],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $dataStyle = [
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ];

        // Set column widths
        foreach (range('A', 'N') as $column) {
            $sheet->getColumnDimension($column)->setWidth(20);
        }

        // Add headers
        $headers = [
            'A1' => 'first_name', 'B1' => 'last_name', 'C1' => 'middle_initial',
            'D1' => 'extension', 'E1' => 'gender', 'F1' => 'birth_date',
            'G1' => 'email', 'H1' => 'phone_number', 'I1' => 'year_level',
            'J1' => 'student_id', 'K1' => 'campus', 'L1' => 'college',
            'M1' => 'program', 'N1' => 'program_major'
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }
        $sheet->getStyle('A1:N1')->applyFromArray($headerStyle);

        // Initialize variables
        $campuses = [];
        $colleges = [];
        $programs = [];
        $majors = [];

        try {
            // Common validation settings
            $configureValidation = function ($validation, $allowBlank = false) {
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                $validation->setAllowBlank($allowBlank);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
            };

            // Gender Validation
            $genderValidation = $sheet->getDataValidation('E2:E100');
            $configureValidation($genderValidation);
            $genderValidation->setFormula1('"Male,Female,Non-binary,Others"');


        } catch (\Exception $e) {
            \Log::error('Template generation error: ' . $e->getMessage());
        }



        // Add sample data row
        $sampleData = [
            'A2' => 'Juan', 'B2' => 'Dela Cruz', 'C2' => 'M',
            'D2' => 'Jr', 'E2' => 'Male', 'F2' => '2000-01-01',
            'G2' => 'juan.delacruz@example.com', 'H2' => '09123456789',
            'I2' => '3', 'J2' => '2020-12345', 'K2' => 'Tagum Unit',
            'L2' => 'College of Teacher Education and Technology',
            'M2' => 'Bachelor of Science in Information Security',
            'N2' => 'Information Security'
        ];

        foreach ($sampleData as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        $sheet->getStyle('A2:N2')->applyFromArray($dataStyle);

        // Freeze header row and set filters
        $sheet->freezePane('A2');
        $sheet->setAutoFilter('A1:N1');

        // Save the file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($templatePath);
    }

    public function import(): void
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $this->importing = true;
        $this->importError = '';
        $this->importErrors = [];


        try {
            if (!$this->importFile || !$this->importFile->getRealPath()) {
                throw new \Exception('No valid import file found.');
            }

            $filePath = $this->importFile->getRealPath();

            $import = new VotersImport();

            Excel::import($import, $filePath);


            $successCount = $import->getRowCount();
            $failures = $import->failures();
            $failureCount = count($failures);

            // Store errors for display in modal
            $this->importErrors = collect($failures)->map(function ($failure) {
                return [
                    'row' => $failure->row(),
                    'field' => $failure->attribute(),
                    'errors' => $failure->errors()
                ];
            })->toArray();

            if ($failureCount > 0) {
                $this->importError = "Imported {$successCount} positions. {$failureCount} records had errors.";
            }else {
                $this->dispatch('success-voter-import', [
                    'title' => 'Import Complete',
                    'message' => "Imported {$successCount} voter/s. " . ($failureCount ? "{$failureCount} records skipped." : "")
                ]);
                $this->reset('importFile');
                $this->dispatch('voter-imported');
            }



        } catch (\Exception $e) {
            $errorMessage = match (true) {
                str_contains($e->getMessage(), 'duplicate') => 'Duplicate values found in import file',
                str_contains($e->getMessage(), 'required') => 'Missing required fields in import file',
                default => 'Error importing voters. Please check the file format and data.'
            };

            $this->dispatch('fail-voter-import', [
                'title' => 'Import Failed',
                'message' => $errorMessage
            ]);
        } finally {
            $this->importing = false;
        }
    }

    public function exportVoterLists()
    {
        return Excel::download(new VoterExport($this->search), 'LIST_OF_VOTERS.xlsx');

    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-voter.voter-table', [
            'voters' => $this->fetchUsers(),
        ]);
    }
}
