<?php

namespace App\Livewire\Timer;

use Livewire\Component;
use App\Models\Election;
use Carbon\Carbon;

class AdminDashboardTimer extends Component
{
    public $selectedElection;
    public $isPaused = false;
    public $isStopped = false;
    public $remainingTime = 0;

    public $election;
    public $originalEndTime;

    public function mount($selectedElection = null): void
    {
        $this->selectedElection = $selectedElection;

        if ($this->selectedElection) {
            $this->election = Election::find($this->selectedElection);
            $this->originalEndTime = $this->election->end_time;
            $this->remainingTime = $election->remaining_time ??
                Carbon::parse($this->election->end_time)->diffInSeconds(Carbon::now());
        }
    }

    public function pauseElection()
    {
        $election = Election::find($this->selectedElection);

        if ($election) {
            $this->isPaused = true;
            $election->update([
                'remaining_time' => $this->remainingTime,
                'status' => 'paused',
                'is_active' => false
            ]);

            $this->dispatch('timer-paused');
        }
    }

    public function resumeElection()
    {
        $election = Election::find($this->selectedElection);

        if ($election) {
            $this->isPaused = false;
            $newEndTime = Carbon::now()->addSeconds($this->remainingTime);

            $election->update([
                'end_time' => $newEndTime,
                'remaining_time' => null,
                'status' => 'active'
            ]);

            $this->dispatch('timer-resumed', endTime: $newEndTime->toDateTimeString());
        }
    }

    public function stopElection()
    {
        $election = Election::find($this->selectedElection);

        if ($election) {
            $this->isStopped = true;
            $election->update([
                'date_ended' => Carbon::now(),
                'status' => 'completed',
            ]);

            // Dispatch an event with refresh instruction
            $this->dispatch('timer-stopped', shouldRefresh: true);

            // Optionally add a flash message
            session()->flash('election_status', 'Election has been stopped');
        }
    }

    public function render()
    {
        return view('evotar.livewire.timer.admin-dashboard-timer');
    }
}
