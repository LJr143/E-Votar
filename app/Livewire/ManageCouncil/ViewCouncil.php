<?php

namespace App\Livewire\ManageCouncil;

use App\Exports\CandidateExport;
use App\Exports\CouncilExport;
use App\Imports\CouncilImport;
use App\Imports\PositionImport;
use App\Models\Council;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ViewCouncil extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $selectedElection;
    public $perPage = 5;

    public $importFile;
    public $importing = false;
    public $importErrors = [];
    public $importError = '';

    protected $listeners = [
        'council-created' => '$refresh',
        'council-updated' => '$refresh',
        'council-deleted' => '$refresh',
    ];

    public function mount(): void
    {
        $this->selectedElection = session('selectedElection');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function downloadExcelFormat(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Path to your template file
        $templatePath = public_path('templates/council_import_template.xlsx');

        // Check if file exists
        if (!file_exists($templatePath)) {
            // Create a default template if it doesn't exist
            $this->createDefaultTemplate();
        }

        return response()->download($templatePath, 'council_import_template.xlsx');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    protected function createDefaultTemplate(): void
    {
        $templatePath = public_path('templates/council_import_template.xlsx');

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

        // Add headers with style
        // In createDefaultTemplate():
        $sheet->setCellValue('A1', 'name');
        $sheet->getStyle('A1')->applyFromArray($headerStyle);


        // Add description row
        $sheet->setCellValue('A2', 'Council Name (e.g. "Organization of ...")');
        $sheet->getStyle('A2')->getFont()->setItalic(true)
            ->getColor()->setRGB('666666');
        $sheet->getStyle('A2:C2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('F2F2F2');

        // Add sample data row
        $sheet->setCellValue('A3', 'Organization of Sample Students');
        $sheet->getStyle('A3')->applyFromArray($dataStyle);

        // Freeze header row
        $sheet->freezePane('A2');

        // Add filters
        $sheet->setAutoFilter('A1');

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
            $import = new CouncilImport();
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
            }else{
                $this->dispatch('success-position-import', [
                    'title' => 'Import Failed',
                    'message' => "Imported {$successCount} council/s. " .
                        ($failureCount ? "{$failureCount} records skipped." : "")
                ]);
                $this->reset('importFile');
                $this->dispatch('council-imported');
            }



        } catch (\Exception $e) {
            // Simplified error messages
            $errorMessage = match(true) {
                str_contains($e->getMessage(), 'duplicate') => 'Duplicate values found in import file',
                str_contains($e->getMessage(), 'required') => 'Missing required fields in import file',
                default => 'Error importing positions. Please check the file format.'
            };

            $this->dispatch('fail-position-import', [
                'title' => 'Import Failed',
                'message' => $errorMessage
            ]);


            Log::error('Import failed: ' . $e->getMessage());
        } finally {
            $this->importing = false;
        }
    }
    public function resetImport(): void
    {
        $this->reset(['importing', 'importError', 'importErrors', 'importFile']);
    }


    public function exportCouncils()
    {
        return Excel::download(new CouncilExport($this->search), 'LIST_OF_COUNCILS.xlsx');

    }

    public function render()
    {
        return view('evotar.livewire.manage-council.view-council', [
            'councils' => Council::with('program')
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                })
                ->paginate($this->perPage)
        ]);
    }
}
