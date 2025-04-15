<?php

namespace App\Livewire\ManageProgram;

use App\Events\UserActionUpdated;
use App\Models\Program;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteProgram extends Component
{
    public $program;
    public $password;

    public function mount($programId)
    {
        $this->program = Program::find($programId);

    }
    public function delete()
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
        $this->password = '';

        if ($this->program) {
            $this->program->delete();
            $this->dispatch('program-deleted');
        }
    }
    public function render()
    {
        return view('evotar.livewire.manage-program.delete-program');
    }
}
