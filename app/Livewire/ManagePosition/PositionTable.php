<?php

namespace App\Livewire\ManagePosition;

use App\Exports\PositionExport;
use App\Imports\PositionImport;
use App\Models\Position;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

class PositionTable extends Component
{
    use WithPagination, WithFileUploads;

    protected $listeners = [
        'position-created' => '$refresh',
        'position-updated' => '$refresh',
        'party-lists-imported' => '$refresh',
        'position-deleted' => '$refresh'
    ];

    // Component properties
    public $filter = 'all_position';
    public $search = '';
    public $perPage = 10;
    public $importFile;
    public $importing = false;
    public $importErrors = [];
    public $importError = '';


    /**
     * Reset pagination when search is updated.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when filter is updated.
     */
    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Refresh the component when an election is created.
     */
    public function refreshComponent(): void
    {
        $this->resetPage();
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function downloadExcelFormat(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Path to your template file
        $templatePath = public_path('templates/position_import_template.xlsx');

        // Check if file exists
        if (!file_exists($templatePath)) {
            // Create a default template if it doesn't exist
            $this->createDefaultTemplate();
        }

        return response()->download($templatePath, 'position_import_template.xlsx');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function createDefaultTemplate(): void
    {
        $templatePath = public_path('templates/position_import_template.xlsx');

        // Create directory if it doesn't exist
        if (!is_dir(dirname($templatePath))) {
            mkdir(dirname($templatePath), 0755, true);
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define styles
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'EA153D'] // Dark blue
            ],
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
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ];


        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);  // Name
        $sheet->getColumnDimension('B')->setWidth(30);  // Num Winners
        $sheet->getColumnDimension('C')->setWidth(30);  // Num Winners

        // Add headers with style
        // In createDefaultTemplate():
        $sheet->setCellValue('A1', 'name');
        $sheet->setCellValue('B1', 'council_type');
        $sheet->setCellValue('C1', 'num_winners');
        $sheet->getStyle('A1:C1')->applyFromArray($headerStyle);

        $validation = $sheet->getDataValidation('B2:B100');
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input error');
        $validation->setError('Value is not in list');
        $validation->setPromptTitle('Pick from list');
        $validation->setPrompt('Please pick a value from the drop-down list.');
        $validation->setFormula1('"Student Council Election,Local Council Election,Special Election"');

        // Add description row
        $sheet->setCellValue('A2', 'Position name (e.g. "President")');
        $sheet->setCellValue('B2', 'Student Council Position');
        $sheet->setCellValue('C2', 'Number of winners (e.g. "1")');
        $sheet->getStyle('A2:C2')->getFont()->setItalic(true)
            ->getColor()->setRGB('666666');
        $sheet->getStyle('A2:C2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('F2F2F2');

        // Add sample data row
        $sheet->setCellValue('A3', 'President');
        $sheet->setCellValue('B3', 'Student Council Election');
        $sheet->setCellValue('C3', '1');
        $sheet->getStyle('A3:C3')->applyFromArray($dataStyle);

        // Freeze header row
        $sheet->freezePane('A2');

        // Add filters
        $sheet->setAutoFilter('A1:C1');

        // Create writer and save file
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
            $import = new PositionImport();
            Excel::import($import, $this->importFile->getRealPath());

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
            } else {
                // Only dispatch success and close modal if no errors
                $this->dispatch('success-position-import', [
                    'title' => 'Import Successful',
                    'message' => "Successfully imported {$successCount} positions."
                ]);
                $this->reset(['importFile', 'importing']);
                $this->dispatch('party-lists-imported');
            }

        } catch (\Exception $e) {
            $errorMessage = match(true) {
                str_contains($e->getMessage(), 'duplicate') => 'Duplicate values found in import file',
                str_contains($e->getMessage(), 'required') => 'Missing required fields in import file',
                str_contains($e->getMessage(), 'Undefined array key') => 'Invalid column headers in import file',
                str_contains($e->getMessage(), 'Council type field not found') => 'Council type column missing in import file',
                str_contains($e->getMessage(), 'Election type') => 'Invalid council type specified',
                default => 'Error importing positions. Please check the file format.'
            };

            $this->importError = $errorMessage;
        }
    }

    public function resetImport(): void
    {
        $this->reset(['importing', 'importError', 'importErrors', 'importFile']);
    }
    public function exportPositions()
    {
        return Excel::download(new PositionExport($this->search, $this->filter), 'LIST_OF_POSITION.xlsx');

    }

    /**
     * Render the Livewire component view.
     */
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $query = Position::query()->with('electionType');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'all_position') {
            $query->whereHas('electionType', function ($query) {
                $query->whereIn('name', [
                    'Student and Local Council Election',
                    'Student Council Election',
                    'Local Council Election',
                    'Special Election'
                ]);
            });
        } elseif ($this->filter === 'student_and_local_position') {
                $query->whereHas('electionType', function ($query) {
                    $query->where('name', 'Student and Local Council Election');
                });
            } elseif ($this->filter === 'student_position') {
                $query->whereHas('electionType', function ($query) {
                    $query->where('name', 'Student Council Election');
                });
            } elseif ($this->filter === 'local_position') {
                $query->whereHas('electionType', function ($query) {
                    $query->where('name', 'Local Council Election');
                });
            } elseif ($this->filter === 'special_position') {
                $query->whereHas('electionType', function ($query) {
                    $query->where('name', 'Special Election');
                });
            }


        return view('evotar.livewire.manage-position.position-table', [
            'positions' => $query->paginate($this->perPage),
        ]);
    }
}
