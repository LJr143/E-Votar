<?php

namespace App\Livewire\Timer;

use Livewire\Component;

class AdminDashboardTimer extends Component
{
    public $selectedElection;

    public function mount($selectedElection = null): void
    {
        $this->selectedElection = $selectedElection;
    }

    public function render()
    {
        return view('evotar.livewire.timer.admin-dashboard-timer');
    }
}
