<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use App\Models\PartyList;
use Livewire\Component;

class ViewCouncil extends Component
{
    public $search = '';
    public $selectedElection;
    public $councils;

    protected $listeners = [
        'council-created' => '$refresh',
        'council-updated' => '$refresh',
        'council-deleted' => '$refresh',
    ];

    public function mount(): void
    {
        $this->selectedElection = session('selectedElection');
        $this->councils = $this->getCouncilProperty();
    }


    public function getCouncilProperty(): \Illuminate\Database\Eloquent\Collection
    {
        $query = Council::with('program');

        // Apply search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Return the results
        return $query->get();
    }
    public function render()
    {
        return view('evotar.livewire.manage-election.view-council', [
            'councils'=>$this->councils,
        ]);
    }
}
