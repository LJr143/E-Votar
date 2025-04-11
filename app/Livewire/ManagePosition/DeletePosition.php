<?php

namespace App\Livewire\ManagePosition;

use App\Models\Position;
use Hash;
use Livewire\Component;

class DeletePosition extends Component
{
    public Position $position;
    public $password;

    public function mount($positionId): void
    {
        // Retrieve the position using the provided ID
        $this->position = Position::findOrFail($positionId);
    }

    public function deletePosition(): void
    {
        // Validate the password field
        $this->validate([
            'password' => 'required|string',
        ]);

        // Ensure the user is authenticated
        $user = auth()->user();

        if (!$user || !Hash::check($this->password, $user->password)) {
            $this->addError('password', 'The provided password is incorrect.');
            return;
        }

        // Delete the position
        $this->position->delete();

        // Flash a success message
        session()->flash('success', 'Position deleted successfully.');

        // Emit an event to refresh the position table
        $this->dispatch('position-deleted');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        // Return the delete position view
        return view('evotar.livewire.manage-position.delete-position');
    }
}
