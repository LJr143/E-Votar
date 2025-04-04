<?php

namespace App\Exports;

use App\Models\Candidate;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class VoteTallyExport implements FromView, ShouldAutoSize, WithDrawings, WithEvents
{
    public $candidates;
    public $search;
    public $filter;
    public $selectedElection;

    public function __construct($search, $filter, $selectedElection)
    {
        $this->search = $search;
        $this->filter = $filter;
        $this->selectedElection = $selectedElection;
    }

    public function view(): View
    {
        if (!$this->selectedElection) {
            return view('evotar.reports.exports.voteTallyReport', [
                'groupedCandidates' => collect()
            ]);
        }

        $query = Candidate::with([
            'users', // Changed from users to user if one-to-one
            'users.program.council',
            'elections',
            'election_positions.position.electionType', // Fixed relationship name
            'partyLists'
        ])
            ->withCount('votes')
            ->whereHas('elections', function ($q) {
                $q->where('id', $this->selectedElection);
            });

        if ($this->search) {
            $query->whereHas('users', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter) {
            $query->whereHas('elections.election_type', function ($q) {
                $q->where('name', $this->filter);
            });
        }

        // Group candidates by council (election type)
        $groupedCandidates = $query->get()->groupBy(function ($candidate) {
            $electionType = $candidate->election_positions->position->electionType->name ?? 'Unknown Election';

            if ($electionType === 'Student Council Election') {
                return 'TAGUM STUDENT COUNCIL';
            }

            if ($electionType === 'Local Council Election') {
                return $candidate->users->program->council->name ?? 'Unknown Local Council';
            }

            return strtoupper($electionType);
        });


        return view('evotar.reports.exports.voteTallyReport', [
            'groupedCandidates' => $groupedCandidates
        ]);
    }

    public function drawings(): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('University Logo');
        $drawing->setPath(public_path('storage/assets/image/University of Southeastern Philippines Tagum Unit.png'));
        $drawing->setHeight(50);
        $drawing->setWidth(300);
        $drawing->setOffsetX(10);
        $drawing->setCoordinates('D1');

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Set autofilter on a range that includes your header row.
                // Assuming headers start at A6 and go up to H6 (adjust if needed)
                $event->sheet->getDelegate()->setAutoFilter('A4:H4');
            },
        ];
    }

}
