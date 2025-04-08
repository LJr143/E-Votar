<?php

namespace App\Exports;

use App\Models\Candidate;
use App\Models\IpRecord;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class IpRecordsExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $records;
    public $search;


    public function __construct($search){
        $this->search = $search;
    }

    public function view(): View
    {
        $query = IpRecord::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('ip_address', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('first_name', 'like', '%' . $this->search . '%')->orWhere('last_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->with('user')
            ->orderBy('last_seen_at', 'desc');

        $this->records = $query->get();

        return view('evotar.reports.exports.ipRecordReport', [
            'iprecords' => $this->records
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
