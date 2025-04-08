<?php

namespace App\Exports;

use App\Models\Council;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class VoterExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $voters;
    public $search;

    public function __construct($search){
        $this->search = $search;
    }

    public function view(): View
    {

        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'voter');
        })
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%');
            });


        $this->voters = $query->get();

        return view('evotar.reports.exports.voterReport', [
            'voters' => $this->voters
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

        $drawing->setCoordinates('I1');


        return $drawing;
    }
}
