<?php

namespace App\Exports;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rules\Can;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class CandidateExport implements FromView, ShouldAutoSize, WithDrawings
{
    public $candidates;
    public $search;
    public $filter;
    public $selectedElection;

    public function __construct($search, $filter, $selectedElection){
        $this->search = $search;
        $this->filter = $filter;
        $this->selectedElection = $selectedElection;
    }

    public function view(): View
    {
        if (!$this->selectedElection) {
            $this->candidates = [];
            return view('evotar.reports.exports.candidateReport', [
                'candidates' => $this->candidates
            ]);
        }

        $query = Candidate::with(['users', 'users.program.council', 'elections', 'election_positions.position', 'election_positions.position.electionType'])
            ->withCount('votes')
            ->join('election_positions', 'candidates.election_position_id', '=', 'election_positions.id')
            ->orderBy('election_positions.position_id', 'asc')
            ->select('candidates.*');

        if ($this->search) {
            $query->whereHas('users', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedElection) {
            $query->whereHas('elections', function ($q) {
                $q->where('id', $this->selectedElection);
            });
        }

        if ($this->filter) {
            $query->whereHas('elections.election_type', function ($q) {
                $q->where('name', $this->filter);
            });
        }

        $this->candidates = $query->get();

        return view('evotar.reports.exports.candidateReport', [
            'candidates' => $this->candidates
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
