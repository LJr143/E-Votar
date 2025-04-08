<?php

namespace App\Exports;

use App\Models\College;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProgramExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $colleges;
    public $search;
    public $filter;

    public function __construct($search, $filter)
    {
        $this->search = $search;
        $this->filter = $filter;
    }

    public function view(): View
    {
        $query = College::query()->with('programs');

        // Apply search filter across campus or college names
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhereHas('programs', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        }

        // Apply campus filter
        if ($this->filter && $this->filter !== 'All Campus') {
            $query->where('name', $this->filter);
        }

        $this->colleges = $query->get();

        return view('evotar.reports.exports.programsReport', [
            'colleges' => $this->colleges
        ]);
    }

    /**
     * @throws Exception
     */
    public function drawings(): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('University Logo');
        $drawing->setPath(public_path('storage/assets/image/University of Southeastern Philippines Tagum Unit.png'));
        $drawing->setHeight(50);
        $drawing->setWidth(300);
        $drawing->setOffsetX(100);
        $drawing->setCoordinates('A1');

        return $drawing;
    }
}
