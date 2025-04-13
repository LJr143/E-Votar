<?php

namespace App\Livewire\Header;

use AllowDynamicProperties;
use App\Models\Election;
use Livewire\Component;

#[AllowDynamicProperties] class Header extends Component
{
    public function render()
    {
        return view('evotar.livewire.header.header');
    }
}
