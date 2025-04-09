<?php

namespace App\Livewire\ComelecWebsite;

use App\Models\Council;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SelectedOrganization extends Component
{
    public $council;

    public function mount(Council $council)
    {
        $this->council = $council;
        Log::info($council->name);
    }
    public function render()
    {
        return view('evotar.livewire.comelec-website.selected-organization');
    }
}
