<?php

namespace App\Livewire\ManageCouncil;

use App\Models\Council;
use App\Models\CouncilPositionSetting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteCouncil extends Component
{

    public $password;
    public $council;

    public function mount(int $councilId): void
    {
        $this->council = Council::findOrFail($councilId);
    }

    public function deleteCouncil(): void
    {
        $this->validate([
            'password' => 'required|string',
        ]);


        // Verify the provided password matches the user's password
        if (!Hash::check($this->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => 'The password does not match our records.',
            ]);
        }

        if (!$this->password) {
            throw ValidationException::withMessages([
                'password' => 'The password cannot be empty.',
            ]);
        }

        if ($this->council->exists) {
            // First delete all related position settings
            CouncilPositionSetting::where('council_id', $this->council->id)->delete();

            // Then delete the council itself
            $this->council->delete();

            $this->dispatch('council-deleted', message: 'Council and its position settings deleted successfully');
        }
    }

    public function render()
    {
        return view('evotar.livewire.manage-council.delete-council');
    }
}
