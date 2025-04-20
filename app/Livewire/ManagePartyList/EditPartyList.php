<?php

namespace App\Livewire\ManagePartyList;

use App\Models\PartyList;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPartyList extends Component
{
    use WithFileUploads;

    public $partyList;
    public $name;
    public $logo;
    public $temporaryLogoUrl = null;
    public $currentLogoPath;
    public $currentLogoUrl;

    public function mount($partyListId): void
    {
        $this->partyList = PartyList::find($partyListId);

        if (!$this->partyList) {
            abort(404, 'Party List not found');
        }

        $this->name = $this->partyList->name;
        $this->currentLogoPath = $this->partyList->logo_path;
        $this->temporaryLogoUrl = $this->getCurrentLogoUrl();
        $this->currentLogoUrl = $this->currentLogoPath;
    }

    public function updatedLogo()
    {
        $this->validateOnly('logo', [
            'logo' => 'nullable|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:1024',
        ]);

        if ($this->logo) {
            $this->temporaryLogoUrl = $this->logo->temporaryUrl();
            $this->currentLogoUrl = null;
        }
    }

    public function removeLogo()
    {
        $this->reset(['logo', 'temporaryLogoUrl']);
        $this->currentLogoPath = null;
        $this->currentLogoUrl = null;
    }

    protected function getCurrentLogoUrl(): ?string
    {
        return $this->currentLogoPath
            ? Storage::disk('public')->url($this->currentLogoPath)
            : null;
    }

    public function editPartyList(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024',
        ]);

        if ($this->logo) {
            if ($this->currentLogoPath && Storage::disk('public')->exists($this->currentLogoPath)) {
                Storage::disk('public')->delete($this->currentLogoPath);
            }
            $this->currentLogoPath = $this->logo->store('party-list-logos', 'public');
        }

        $this->partyList->update([
            'name' => $this->name,
            'logo_path' => $this->currentLogoPath
        ]);

        $this->dispatch('party-list-updated');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('evotar.livewire.manage-party-list.edit-party-list');
    }
}
