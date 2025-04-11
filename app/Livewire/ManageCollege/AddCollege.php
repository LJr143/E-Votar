<?php

namespace App\Livewire\ManageCollege;

use App\Models\Campus;
use App\Models\College;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddCollege extends Component
{
    public $campus;
    public $name;

    public function mount($campusId): void
    {
        $this->campus = Campus::find($campusId);
        if (!$this->campus) {
            abort(404, 'Campus not found');
        }
    }

    public function submit(): void
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('colleges')->where(function ($query) {
                    return $query->where('campus_id', $this->campus->id);
                }),
            ]

        ]);

        College::create([
            'name' => $this->name,
            'campus_id' => $this->campus->id,
        ]);

        $this->dispatch('college-created');

        $this->reset('name');

        session()->flash('message', 'College added successfully!');
    }

    public function render()
    {
        return view('evotar.livewire.manage-college.add-college', [
            'campus' => $this->campus,
        ]);
    }
}
