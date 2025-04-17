<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class PrivacyAgreement extends Component
{
    public bool $showModal = false;
    public bool $agreed = false;

    public function mount()
    {
        // Check if user has already agreed
        if (!Cookie::get('privacy_agreed')) {
            $this->showModal = true;
        }
    }

    // In your PrivacyAgreement Livewire component
    public function agree()
    {
        Cookie::queue('privacy_agreed', true, 60 * 24 * 365);
        $this->showModal = false;
        $this->dispatch('privacy-accepted');
    }

    public function render()
    {
        return view('evotar.livewire.privacy-agreement');
    }
}
