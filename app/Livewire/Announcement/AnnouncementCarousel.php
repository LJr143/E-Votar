<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
use App\Models\Announcement;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class AnnouncementCarousel extends Component
{
    public $announcements = [];
    public $currentIndex = 0;
    public $visibleSlides = 3; // Default value
    public $totalAnnouncements = 0;

    public function mount()
    {
        // Initial load, visibleSlides will be updated via JavaScript
        $this->loadAnnouncements();
    }

    #[On('window-resized')]
    public function updateVisibleSlides($visibleSlides)
    {
        $this->visibleSlides = $visibleSlides;
    }

    public function loadAnnouncements()
    {
        $this->announcements = Announcement::query()
            ->where('status', 'published')
            ->where('publication_at', '<=', now())
            ->orderBy('publication_at', 'desc')
            ->get()
            ->map(function ($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'content' => $announcement->content,
                    'cover_image' => $announcement->cover_image,
                    'status' => $announcement->status,
                    'campus' => $announcement->campus,
                    'publication_at' => $announcement->publication_at,
                ];
            });

        $this->totalAnnouncements = $this->announcements->count();
    }

    public function next()
    {
        if ($this->currentIndex < $this->totalAnnouncements - $this->visibleSlides) {
            $this->currentIndex += $this->visibleSlides;
        }
    }

    public function previous()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex -= $this->visibleSlides;
        }
    }

    public function goToPage($page)
    {
        $this->currentIndex = $page * $this->visibleSlides;
    }

    public function render()
    {
        return view('evotar.livewire.announcement.announcement-carousel');
    }
}
