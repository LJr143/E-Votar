<?php

namespace App\Livewire\Announcement;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EditAnnouncement extends Component
{
    use WithFileUploads;

    public Announcement $announcement;
    public $title;
    public $content;
    public $dateTimeLocal;
    public $coverImage;
    public $mediaFiles = ['images' => [], 'videos' => []];
    public $status;
    public $existingCover;
    public $existingMedia = [];
    public $removedMedia = [];
    public array $mediaPreviews = [];
    public bool $titleError = false;
    public bool $contentError = false;
    public bool $dateTimeError = false;
    public string $selectedFileName = '';
    public $coverImageUrl;

    protected $listeners = [
        'fileUploaded' => 'handleMediaUpload',
    ];

    protected $messages = [
        'dateTimeLocal.after_or_equal' => 'The publication date and time must be now or in the future.',
        'coverImage.image' => 'The cover image must be an image file.',
        'coverImage.max' => 'The cover image must not exceed 2MB.',
        'mediaFiles.images.*.image' => 'Each image must be a valid image file.',
        'mediaFiles.images.*.max' => 'Each image must not exceed 2MB.',
        'mediaFiles.videos.*.mimes' => 'Each video must be in mp4, mov, or avi format.',
        'mediaFiles.videos.*.max' => 'Each video must not exceed 1GB.',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'dateTimeLocal' => 'required|date|after_or_equal:now',
        'coverImage' => 'nullable|image|max:2048',
        'mediaFiles.images.*' => 'nullable|image|max:2048',
        'mediaFiles.videos.*' => 'nullable|mimes:mp4,mov,avi|max:1048576',
        'status' => 'required|in:draft,published',
    ];

    public function mount(Announcement $announcement)
    {
        $this->announcement = $announcement;
        $this->title = $announcement->title;
        $this->content = $announcement->content;
        $this->dateTimeLocal = $announcement->publication_at
            ? Carbon::parse($announcement->publication_at)->format('Y-m-d\TH:i')
            : now()->format('Y-m-d\TH:i');
        $this->status = $announcement->status;
        $this->existingCover = $announcement->cover_image;
        $this->coverImageUrl = $announcement->cover_image
            ? Storage::url($announcement->cover_image)
            : null;

        if ($announcement->media) {
            $this->existingMedia = json_decode($announcement->media, true) ?: [];
            $this->prepareExistingMediaPreviews();
        }
    }

    protected function prepareExistingMediaPreviews()
    {
        foreach ($this->existingMedia as $media) {
            $this->mediaPreviews[] = [
                'id' => Str::random(20),
                'type' => $media['type'],
                'name' => $media['name'],
                'size' => $media['size'],
                'path' => Storage::url($media['path']),
                'is_existing' => true,
            ];
        }
    }

    public function updatedCoverImage()
    {
        $this->validateOnly('coverImage');
        $this->coverImageUrl = $this->coverImage->temporaryUrl();
        $this->selectedFileName = $this->coverImage->getClientOriginalName();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->resetErrorState($propertyName);
    }

    public function updatedMediaFiles($value, $key)
    {
        $this->handleMediaUpload();
    }

    public function handleMediaUpload()
    {
        $this->validate([
            'mediaFiles.images.*' => 'nullable|image|max:2048',
            'mediaFiles.videos.*' => 'nullable|mimes:mp4,mov,avi|max:10240',
        ]);

        // Process images
        foreach ($this->mediaFiles['images'] as $file) {
            $this->addMediaPreview($file, 'images');
        }

        // Process videos
        foreach ($this->mediaFiles['videos'] as $file) {
            $this->addMediaPreview($file, 'videos');
        }
    }

    protected function addMediaPreview($file, string $type)
    {
        $this->mediaPreviews[] = [
            'id' => Str::random(20),
            'type' => $type,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'temp_url' => $file->temporaryUrl(),
            'is_existing' => false,
        ];
    }

    public function removeMedia(string $id)
    {
        $index = array_search($id, array_column($this->mediaPreviews, 'id'));

        if ($index !== false) {
            $media = $this->mediaPreviews[$index];

            if (isset($media['is_existing']) && $media['is_existing']) {
                // For existing media, mark for removal
                $this->removedMedia[] = $media['path'];
            }

            // Remove from previews
            unset($this->mediaPreviews[$index]);
            $this->mediaPreviews = array_values($this->mediaPreviews);

            // Remove from mediaFiles if it's a new upload
            if (isset($media['temp_url'])) {
                foreach ($this->mediaFiles[$media['type']] as $key => $file) {
                    if ($file->getClientOriginalName() === $media['name']) {
                        unset($this->mediaFiles[$media['type']][$key]);
                        $this->mediaFiles[$media['type']] = array_values($this->mediaFiles[$media['type']]);
                        break;
                    }
                }
            }
        }
    }

    public function saveAsDraft()
    {
        $this->save('draft');
    }

    public function publish()
    {
        $this->save('published');
    }

    protected function save(string $status)
    {
        $this->validate();

        try {
            $data = $this->prepareAnnouncementData($status);
            $this->announcement->update($data);
            $this->cleanupRemovedMedia();
            $this->dispatch('announcement-edit-update');
            session()->flash('message', "Announcement updated successfully.");

        } catch (\Exception $e) {
            Log::error('Failed to update announcement', ['error' => $e->getMessage()]);
            $this->addError('general', 'Failed to update announcement. Please try again.');
        }
    }

    protected function prepareAnnouncementData(string $status): array
    {
        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'publication_at' => $this->dateTimeLocal,
            'status' => $status,
        ];

        // Handle cover image
        if ($this->coverImage) {
            // Delete old cover if exists
            if ($this->existingCover) {
                Storage::delete($this->existingCover);
            }
            $data['cover_image'] = $this->coverImage->store('announcements/covers', 'public');
        } elseif (in_array($this->existingCover, $this->removedMedia)) {
            // Cover was removed
            $data['cover_image'] = null;
        }

        // Handle media files
        $mediaData = $this->processMediaFiles();

        // Keep existing media that wasn't removed
        $existingMediaToKeep = array_filter($this->existingMedia, function($media) {
            return !in_array($media['path'], $this->removedMedia);
        });

        $data['media'] = json_encode(array_merge($existingMediaToKeep, $mediaData));

        return $data;
    }

    protected function cleanupRemovedMedia()
    {
        foreach ($this->removedMedia as $path) {
            Storage::delete($path);
        }
    }

    protected function processMediaFiles(): array
    {
        $mediaData = [];

        foreach (['images', 'videos'] as $type) {
            if (!empty($this->mediaFiles[$type])) {
                foreach ($this->mediaFiles[$type] as $file) {
                    $path = $this->storeFile($file, 'announcements/' . $type);
                    $mediaData[] = [
                        'type' => $type,
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                    ];
                }
            }
        }

        return $mediaData;
    }

    protected function storeFile($file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    protected function resetErrorState(string $propertyName): void
    {
        $errorFlags = [
            'title' => 'titleError',
            'content' => 'contentError',
            'dateTimeLocal' => 'dateTimeError',
        ];

        if (isset($errorFlags[$propertyName])) {
            $this->{$errorFlags[$propertyName]} = false;
        }
    }
    public function formatFileSize(int $bytes): string
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
        return view('evotar.livewire.announcement.edit-announcement', [
            'formattedDate' => Carbon::parse($this->dateTimeLocal)->format('F j, Y'),
        ]);
    }
}
