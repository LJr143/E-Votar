<?php

namespace App\Exports;

use App\Models\College;
use App\Models\Program;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProgramMajorExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $programs;
    public $search;
    public $filter;

    public function __construct($search, $filter)
    {
        $this->search = $search;
        $this->filter = $filter;
    }

    public function view(): View
    {
        $query = Program::query()->with('majors', 'college.campus');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhereHas('majors', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('college.campus', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        }


        // Apply campus filter
        if ($this->filter !== 'All Campus') {
            $query->whereHas('college.campus', function ($q) {
                $q->where('name', $this->filter);
            });
        }


        $this->programs = $query->get();

        return view('evotar.reports.exports.programMajorReport', [
            'programs' => $this->programs
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
