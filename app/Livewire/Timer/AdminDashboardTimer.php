<?php

namespace App\Livewire\Timer;

use App\Events\ElectionStatus;
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
            $this->remainingTime = $this->election->remaining_time ??
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

            event(new ElectionStatus());
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

            event(new ElectionStatus());
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

            event(new ElectionStatus());
            // Dispatch an event with refresh instruction
            $this->dispatch('timer-stopped', shouldRefresh: true);

            // Optionally add a flash message
            session()->flash('election_status', 'Election has been stopped');
        }
    }

    public function render()
    {
        if ($this->selectedElection) {
            $this->election = Election::find($this->selectedElection);

            $this->isPaused = $this->election->status === 'paused';
            $this->isStopped = $this->election->status === 'completed';
        }
        return view('evotar.livewire.timer.admin-dashboard-timer');
    }
}
