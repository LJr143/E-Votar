<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;

class SelectedAnnouncement extends Component
{
    public Announcement $announcement;
    public $mediaItems = [];
    public $coverImageUrl;
    public $formattedDate;
    public $relatedAnnouncements;
    public $shareUrl;
    public $shareTitle;

    public function mount(Announcement $announcement)
    {
        $this->announcement = $announcement; // Load any relationships if needed
        $this->loadMedia();
        $this->loadRelatedAnnouncements();
        $this->prepareSharing();

        // Handle null publication_at
        $this->formattedDate = $announcement->publication_at
            ? $announcement->publication_at->format('F j, Y, g:i a')
            : 'Not scheduled';
    }

    protected function loadMedia()
    {
        // Load cover image URL if exists
        if ($this->announcement->cover_image) {
            $this->coverImageUrl = Storage::disk('public')->exists($this->announcement->cover_image)
                ? asset('storage/' . $this->announcement->cover_image)
                : null;
        }

        // Load media items if exists
        if ($this->announcement->media) {
            $mediaData = json_decode($this->announcement->media, true);
            foreach ($mediaData as $item) {
                if (Storage::disk('public')->exists($item['path'])) {
                    $this->mediaItems[] = [
                        'type' => $item['type'],
                        'name' => $item['name'],
                        'url' => asset('storage/' . $item['path']),
                        'size' => $this->formatFileSize($item['size']),
                    ];
                }
            }
        }
    }

    protected function loadRelatedAnnouncements()
    {
        $this->relatedAnnouncements = Announcement::query()
            ->where('id', '!=', $this->announcement->id)
            ->where('status', 'published')
            ->orderBy('publication_at', 'desc')
            ->limit(5)
            ->get();
    }

    protected function prepareSharing()
    {
        $this->shareUrl = route('comelec-website.selected-announcement', $this->announcement);
        $this->shareTitle = Str::limit($this->announcement->title, 100);
    }

    protected function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }

    public function render()
    {
        return view('evotar.livewire.announcement.selected-announcement', [
            'title' => $this->announcement->title,
            'description' => Str::limit(strip_tags($this->announcement->content), 160),
            'image' => $this->coverImageUrl,
        ]);


    }
}
