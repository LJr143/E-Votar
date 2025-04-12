<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CreateAnnouncement extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $content = '';
    public string $dateTimeLocal = '';
    public $coverImage;
    public array $mediaPreviews = [];
    public array $mediaFiles = [
        'images' => [],
        'videos' => [],
    ];
    public bool $titleError = false;
    public bool $contentError = false;
    public bool $dateTimeError = false;
    public string $selectedFileName = '';
    public $coverImageUrl;

    protected $listeners = [
        'fileUploaded' => 'handleMediaUpload',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'dateTimeLocal' => 'required|date|after_or_equal:now',
        'coverImage' => 'nullable|image|max:2048',
        'mediaFiles.images.*' => 'nullable|image|max:2048',
        'mediaFiles.videos.*' => 'nullable|mimes:mp4,mov,avi|max:10240',
    ];

    protected $messages = [
        'dateTimeLocal.after_or_equal' => 'The publication date and time must be now or in the future.',
        'coverImage.image' => 'The cover image must be an image file.',
        'coverImage.max' => 'The cover image must not exceed 2MB.',
        'mediaFiles.images.*.image' => 'Each image must be a valid image file.',
        'mediaFiles.images.*.max' => 'Each image must not exceed 2MB.',
        'mediaFiles.videos.*.mimes' => 'Each video must be in mp4, mov, or avi format.',
        'mediaFiles.videos.*.max' => 'Each video must not exceed 10MB.',
    ];

    public function mount(): void
    {
        $this->dateTimeLocal = now()->format('Y-m-d\TH:i');
        $this->mediaFiles = [
            'images' => [],
            'videos' => [],
        ];
        $this->mediaPreviews = [];
    }

    public function updatedCoverImage()
    {
        $this->coverImageUrl = $this->coverImage->temporaryUrl();
    }

    public function updated($propertyName): void
    {
        try {
            $this->validateOnly($propertyName);
            $this->resetErrorState($propertyName);

            if ($propertyName === 'coverImage' && $this->coverImage) {
                $this->handleCoverImageUpload();
            }
        } catch (ValidationException $e) {
            // Errors handled by Livewire
        }
    }

    protected function handleCoverImageUpload(): void
    {
        if (!$this->coverImage) {
            return;
        }

        try {
            $this->validateOnly('coverImage');
            $this->selectedFileName = $this->coverImage->getClientOriginalName();
            Log::info('Cover image uploaded', ['name' => $this->selectedFileName]);
        } catch (ValidationException $e) {
            $this->resetCoverImageState();
        } catch (\Exception $e) {
            Log::error('Cover image processing failed', ['error' => $e->getMessage()]);
            $this->addError('coverImage', 'Failed to process cover image.');
            $this->resetCoverImageState();
        }
    }

    public function updatedMediaFiles($value, $key)
    {
        $this->handleMediaUpload();
    }

    // Add this method to handle media uploads consistently
    public function handleMediaUpload()
    {
        $this->validate([
            'mediaFiles.images.*' => 'nullable|image|max:2048',
            'mediaFiles.videos.*' => 'nullable|mimes:mp4,mov,avi|max:10240',
        ]);

        $this->mediaPreviews = []; // Clear previous previews

        // Process images
        foreach ($this->mediaFiles['images'] as $file) {
            $this->addMediaPreview($file, 'images');
        }

        // Process videos
        foreach ($this->mediaFiles['videos'] as $file) {
            $this->addMediaPreview($file, 'videos');
        }

        Log::info('Media files processed', [
            'image_count' => count($this->mediaFiles['images']),
            'video_count' => count($this->mediaFiles['videos']),
            'previews_count' => count($this->mediaPreviews)
        ]);
    }

    protected function addMediaPreview($file, string $type)
    {
        try {
            $this->mediaPreviews[] = [
                'id' => Str::random(20), // Simple string ID
                'type' => $type,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'temp_url' => $file->temporaryUrl(),
            ];
        } catch (\Exception $e) {
            Log::error("Media preview error", ['error' => $e->getMessage()]);
        }
    }

    public function removeMedia(string $id): void
    {
        // Find the media to remove
        $index = array_search($id, array_column($this->mediaPreviews, 'id'));

        if ($index !== false) {
            $media = $this->mediaPreviews[$index];
            $type = $media['type'];

            // Remove from mediaFiles array
            foreach ($this->mediaFiles[$type] as $key => $file) {
                if ($file->getClientOriginalName() === $media['name']) {
                    unset($this->mediaFiles[$type][$key]);
                    break;
                }
            }

            // Reindex array
            $this->mediaFiles[$type] = array_values($this->mediaFiles[$type]);

            // Remove from previews
            unset($this->mediaPreviews[$index]);
            $this->mediaPreviews = array_values($this->mediaPreviews);

            $this->dispatch('media-removed');
        }
    }

    public function saveAsDraft(): void
    {
        $this->save('draft');
    }

    public function publish(): void
    {
        $this->save('published');
    }

    public function clearForm(): void
    {
        $this->reset();
        $this->dateTimeLocal = now()->format('Y-m-d\TH:i');
        $this->mediaPreviews = [];
        $this->mediaFiles = [];
        $this->resetErrorBag();
        Log::info('Form cleared');
    }

    protected function save(string $status): void
    {
        try {
            $this->validate();
            $data = $this->prepareAnnouncementData($status);
            Announcement::create($data);
            $this->clearForm();
            session()->flash('message', "Announcement $status successfully.");
            Log::info('Announcement saved', ['status' => $status, 'title' => $data['title']]);
        } catch (ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            // Validation errors handled by Livewire
        } catch (\Exception $e) {
            Log::error('Failed to save announcement', ['error' => $e->getMessage()]);
            $this->addError('general', 'Failed to save announcement. Please try again.');
        }
    }

    protected function prepareAnnouncementData(string $status): array
    {
        $coverImagePath = $this->coverImage ? $this->storeFile($this->coverImage, 'announcements/covers') : null;
        $mediaData = $this->processMediaFiles();

        return [
            'title' => $this->title,
            'content' => $this->content,
            'publication_at' => $this->dateTimeLocal,
            'cover_image' => $coverImagePath,
            'media' => !empty($mediaData) ? json_encode($mediaData) : null,
            'status' => $status,
        ];
    }

    protected function processMediaFiles(): array
    {
        $mediaData = [];

        foreach (['images', 'videos'] as $type) {
            if (!empty($this->mediaFiles[$type])) {
                foreach ($this->mediaFiles[$type] as $file) {
                    if (!$this->isValidUploadedFile($file)) {
                        Log::warning('Skipping invalid media file', ['type' => $type]);
                        continue;
                    }
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

    protected function isValidUploadedFile($file): bool
    {
        return $file instanceof TemporaryUploadedFile && method_exists($file, 'getClientOriginalName') && method_exists($file, 'store');
    }

    protected function resetCoverImageState(): void
    {
        $this->coverImage = null;
        $this->selectedFileName = '';
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
        return view('evotar.livewire.announcement.create-announcement', [
            'coverImageUrl' => $this->coverImage ? $this->coverImage->temporaryUrl() : null,
            'formattedDate' => date('F j, Y', strtotime($this->dateTimeLocal)),
        ]);
    }
}
