<?php

namespace App\Livewire;

use App\Models\Election;
use Livewire\Component;

class ElectionSelect extends Component
{
    public $selectedElection;
    public $elections;
    public $filter;


    public function mount(): void
    {
        // Fetch all elections
        $this->elections = Election::with(['campus', 'election_type'])->get();

        // Check if there are any elections
        if ($this->elections->isEmpty()) {
            $this->selectedElection = null; // No election available
            session()->forget('selectedElection'); // Remove any old session value
            \Log::info('No elections found.');
            return;
        }

        // Initialize selectedElection from session
        if (session()->has('selectedElection')) {
            $this->selectedElection = session('selectedElection');
            \Log::info('Selected Election from Session:', ['selectedElection' => $this->selectedElection]);
        } else {
            // Set the selected election to the latest election if no session value exists
            $latestElection = Election::latest('created_at')->first();
            $this->selectedElection = $latestElection->id; // Store the election ID
            session(['selectedElection' => $latestElection->id]); // Store the latest election ID in the session
            \Log::info('Selected Election set to Latest:', ['selectedElection' => $this->selectedElection]);
        }
    }

    public function updatedSelectedElection($value): void
    {
        // Store the selected election in the session
        session(['selectedElection' => $value]);

        // Save the session to ensure the changes are persisted
        session()->save();

        \Log::info('Selected Election Updated:', ['selectedElection' => $value]);

        // Force a re-render
        $this->refresh = true;

        // Reload the page
        $this->redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('evotar.livewire.election-select');
    }
}
