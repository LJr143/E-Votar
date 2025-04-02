<?php

namespace App\Exports;

use App\Models\Candidate;
use App\Models\Position;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PositionExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $positions;
    public $search;
    public $filter;

    public function __construct($search, $filter){
        $this->search = $search;
        $this->filter = $filter;
    }

    public function view(): View
    {


        $query = Position::query()->with('electionType')
            ->orderBy('created_at', 'asc')
            ->select('positions.*');

        if ($this->search) {
            $query->whereHas('electionType', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });

            $query->where('positions.name', 'like', '%' . $this->search . '%');
        }


        if ($this->filter === 'all_position') {
            // Do not filter anything, return all positions
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

        $this->positions = $query->get();

        return view('evotar.reports.exports.positionReport', [
            'positions' => $this->positions
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
