<?php

namespace App\Exports;

use App\Models\Candidate;
use App\Models\Council;
use App\Models\Election;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class CouncilExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $councils;
    public $search;

    public function __construct($search){
        $this->search = $search;
    }

    public function view(): View
    {

        $query = Council::query()
            ->orderBy('created_at', 'asc');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $this->councils = $query->get();

        return view('evotar.reports.exports.councilReport', [
            'councils' => $this->councils
        ]);
    }

    /**
     * @throws Exception
     */
    // Alternative drawing approach
    public function drawings(): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('University Logo');
        $drawing->setPath(public_path('storage/assets/image/University of Southeastern Philippines Tagum Unit.png'));
        $drawing->setHeight(50);
        $drawing->setWidth(300);
        $drawing->setOffsetX(250);

        $drawing->setCoordinates('C1');


        return $drawing;
    }
}
