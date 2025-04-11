<?php

namespace App\Exports;

use App\Models\Council;
use App\Models\PartyList;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PartyListExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $party_lists;
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

        $this->party_lists = $query->get();

        return view('evotar.reports.exports.partyListReport', [
            'party_lists' => $this->party_lists
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
