<?php

namespace App\Livewire\Timer;

use Livewire\Component;

class WebsiteDashboardTimer extends Component
{
    public $selectedElection;

    public function mount($selectedElection = null): void
    {
        $this->selectedElection = $selectedElection;
    }

    public function render()
    {
        return view('evotar.livewire.timer.website-dashboard-timer');
    }
}
