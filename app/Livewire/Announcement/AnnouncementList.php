<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
use App\Models\Announcement;
use Livewire\WithPagination;

class AnnouncementList extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // 'all', 'published', 'draft'
    public $perPage = 6;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        session()->flash('message', 'Announcement deleted successfully');
    }

    public function render()
    {
        $query = Announcement::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%'.$this->search.'%'))
            ->when($this->filter === 'published', fn($q) => $q->where('status', 'published'))
            ->when($this->filter === 'draft', fn($q) => $q->where('status', 'draft'))
            ->latest();

        return view('evotar.livewire.announcement.announcement-list', [
            'announcements' => $query->paginate($this->perPage),
        ]);
    }
}
