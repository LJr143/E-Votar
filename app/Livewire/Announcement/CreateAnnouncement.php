<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
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
    public array $mediaFiles = [];
    public bool $titleError = false;
    public bool $contentError = false;
    public bool $dateTimeError = false;
    public string $selectedFileName = '';
    public array $mediaPreviews = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'dateTimeLocal' => 'required|date|after_or_equal:now',
        'coverImage' => 'nullable|image|max:2048',
        'mediaFiles' => 'nullable|array',
        'mediaFiles.*' => 'file|max:10240',
    ];

    protected $messages = [
        'dateTimeLocal.after_or_equal' => 'The publication date and time must be now or in the future.',
        'coverImage.image' => 'The cover image must be an image file.',
        'coverImage.max' => 'The cover image must not exceed 2MB.',
        'mediaFiles.*.max' => 'Each media file must not exceed 10MB.',
    ];

    protected $listeners = [
        'fileUploaded' => 'handleMediaUpload',
    ];

    public function mount(): void
    {
        $this->dateTimeLocal = now()->format('Y-m-d\TH:i');
        $this->mediaFiles = [];
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

    public function updatedMediaFiles($value, $key): void
    {
        if (isset($this->mediaFiles[$key]) && $this->isValidUploadedFile($this->mediaFiles[$key])) {
            $file = $this->mediaFiles[$key];
            $mimeType = $file->getMimeType();
            $isPreviewable = in_array($mimeType, config('livewire.temporary_file_upload.preview_mimes', ['image/jpeg', 'image/png', 'image/gif']));

            $preview = [
                'id' => (string) Str::uuid(),
                'type' => $key,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ];

            if ($isPreviewable) {
                $preview['temp_url'] = $file->temporaryUrl();
            }

            // Store preview using the same key as mediaFiles
            $this->mediaPreviews[$key] = $preview;
            Log::info('Media file uploaded via wire:model', ['type' => $key, 'name' => $file->getClientOriginalName(), 'mime' => $mimeType]);
        }
    }

    public function removeMedia(string $id): void
    {
        foreach ($this->mediaPreviews as $key => $preview) {
            if ($preview['id'] === $id) {
                unset($this->mediaPreviews[$key], $this->mediaFiles[$key]);
                Log::info('Media file removed', ['id' => $id, 'key' => $key]);
                break;
            }
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
        if (empty($this->mediaFiles) || !is_array($this->mediaFiles)) {
            Log::info('No media files to process');
            return [];
        }

        $mediaData = [];
        foreach ($this->mediaFiles as $key => $file) {
            if (!$this->isValidUploadedFile($file)) {
                Log::warning('Skipping invalid media file', ['key' => $key]);
                continue;
            }
            $path = $this->storeFile($file, 'announcements/media');
            $mediaData[] = [
                'type' => $this->mediaPreviews[$key]['type'] ?? $key, // Fallback to key if preview missing
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'size' => $file->getSize(),
            ];
        }
        return $mediaData;
    }

    protected function storeFile($file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    protected function isValidUploadedFile($file): bool
    {
        return is_object($file) && method_exists($file, 'getClientOriginalName') && method_exists($file, 'store');
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
