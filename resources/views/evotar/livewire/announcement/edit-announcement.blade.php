<div x-data="{ open: false }" x-cloak>
    <!-- Trigger Button -->
    <button
        @click="open = true"
        class="p-1 hover:bg-gray-100 rounded-full"
        title="Edit announcement"
    >
        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
    </button>


    <!-- Modal -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-white p-6 rounded shadow-md w-4/5 max-h-[700px] overflow-y-auto"
        >
            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Edit Announcement</h2>
                    <p class="text-[10px] text-gray-500 italic">Make changes to the announcement details</p>
                </div>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <form wire:submit.prevent="publish" class="space-y-6">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Left Panel: Form Inputs -->
                        <div class="lg:w-1/3">
                            <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
                                <h2 class="text-sm font-semibold text-gray-800 mb-6">Edit Announcement</h2>

                                <div class="space-y-6">
                                    <!-- Title -->
                                    <div>
                                        <label for="title"
                                               class="block text-xs font-medium text-gray-700 mb-1">Title</label>
                                        <input
                                            wire:model.debounce.500ms="title"
                                            id="title"
                                            type="text"
                                            placeholder="Enter announcement title"
                                            class="w-full px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-black focus:border-black transition-colors {{ $titleError ? 'border-red-500' : 'border-gray-300' }}"
                                        >
                                        @error('title')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Publication Date & Time -->
                                    <div>
                                        <label for="news-date-input"
                                               class="block text-xs font-medium text-gray-700 mb-1">Publication Date &
                                            Time</label>
                                        <input
                                            wire:model="dateTimeLocal"
                                            id="news-date-input"
                                            type="datetime-local"
                                            class="w-full px-3 py-2 border rounded-md text-sm focus:ring-2 focus:ring-black focus:border-black transition-colors {{ $dateTimeError ? 'border-red-500' : 'border-gray-300' }}"
                                        >
                                        @error('dateTimeLocal') <span
                                            class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Cover Image -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Cover Image</label>
                                        <div class="border border-gray-200 rounded-md p-4 bg-gray-50 mb-2">
                                            @if ($coverImageUrl)
                                                <img src="{{ $coverImageUrl }}" alt="Cover preview"
                                                     class="w-32 h-32 object-cover rounded-md">
                                            @elseif ($existingCover)
                                                <img src="{{ Storage::url($existingCover) }}" alt="Existing cover"
                                                     class="w-32 h-32 object-cover rounded-md">
                                            @else
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    No cover image selected
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input
                                                type="file"
                                                id="cover-upload"
                                                class="hidden"
                                                wire:model="coverImage"
                                                accept="image/*"
                                            >
                                            <label for="cover-upload"
                                                   class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-800 py-1 px-3 rounded-md text-xs border border-gray-300 transition-colors">
                                                Change Cover
                                            </label>
                                            @if ($existingCover)
                                                <button
                                                    type="button"
                                                    wire:click="removeMedia('cover')"
                                                    class="cursor-pointer bg-red-50 hover:bg-red-100 text-red-800 py-1 px-3 rounded-md text-xs border border-red-200 transition-colors"
                                                >
                                                    Remove
                                                </button>
                                            @endif
                                            <span
                                                class="text-xs text-gray-500 truncate max-w-xs">{{ $selectedFileName ?: ($existingCover ? 'Current file: '.basename($existingCover) : 'No file chosen') }}</span>
                                        </div>
                                        @error('coverImage') <span
                                            class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Media Upload -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Media</label>
                                        <div class="grid grid-cols-2 gap-2 mb-4">
                                            @foreach (['images' => 'Images', 'videos' => 'Videos'] as $type => $label)
                                                <div class="relative">
                                                    <input
                                                        type="file"
                                                        id="media-{{ $type }}-upload"
                                                        class="hidden"
                                                        wire:model="mediaFiles.{{ $type }}"
                                                        wire:loading.attr="disabled"
                                                        accept="{{ $type === 'images' ? 'image/*' : 'video/*' }}"
                                                        multiple
                                                    >
                                                    <button
                                                        type="button"
                                                        onclick="document.getElementById('media-{{ $type }}-upload').click()"
                                                        class="w-full flex items-center justify-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-xs text-gray-800 hover:bg-gray-100 transition-all duration-300 disabled:opacity-50"
                                                        wire:loading.attr="disabled"
                                                        wire:target="mediaFiles.{{ $type }}"
                                                    >
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                        </svg>
                                                        <span>Add {{ $label }}</span>
                                                    </button>
                                                    <!-- Loading Indicator -->
                                                    <div wire:loading wire:target="mediaFiles.{{ $type }}"
                                                         class="absolute inset-0 flex items-center justify-center bg-gray-100 bg-opacity-75 rounded-md">
                                                        <svg class="animate-spin h-5 w-5 text-gray-600"
                                                             xmlns="http://www.w3.org/2000/svg" fill="none"
                                                             viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                                    stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @error('mediaFiles') <span
                                            class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        @error('mediaFiles.*') <span
                                            class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Media preview section -->
                                    @foreach ($mediaPreviews as $media)
                                        <div
                                            class="relative border border-gray-200 rounded-md p-3 bg-gray-50 flex items-center gap-3">
                                            <!-- Remove Button -->
                                            <button
                                                wire:click="removeMedia('{{ $media['id'] }}')"
                                                class="absolute top-2 right-2 h-5 w-5 rounded-full bg-white hover:bg-gray-100 flex items-center justify-center transition-colors"
                                                title="Remove media"
                                            >
                                                <svg class="h-3 w-3 text-gray-600" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>

                                            <!-- Media Preview -->
                                            @if ($media['type'] === 'images')
                                                <img src="{{ $media['temp_url'] ?? $media['path'] }}"
                                                     alt="{{ $media['name'] }}"
                                                     class="w-16 h-16 object-cover rounded-md">
                                            @elseif ($media['type'] === 'videos')
                                                <video
                                                    class="w-24 h-16 rounded-md object-cover" {{ isset($media['temp_url']) ? '' : 'controls' }}>
                                                    <source src="{{ $media['temp_url'] ?? $media['path'] }}"
                                                            type="video/mp4">
                                                </video>
                                            @endif

                                            <!-- Media Info -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs text-gray-800 truncate">{{ $media['name'] }}</p>
                                                <p class="text-xs text-gray-500">{{ $this->formatFileSize($media['size']) }}</p>
                                                @if (isset($media['is_existing']) && $media['is_existing'])
                                                    <span
                                                        class="inline-block mt-1 px-2 py-0.5 text-xxs bg-gray-100 text-gray-600 rounded">Existing</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Status Toggle -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                        <div class="flex items-center gap-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="status" value="draft"
                                                       class="h-4 w-4 text-black focus:ring-black">
                                                <span class="ml-2 text-xs text-gray-700">Draft</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="status" value="published"
                                                       class="h-4 w-4 text-black focus:ring-black">
                                                <span class="ml-2 text-xs text-gray-700">Published</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="space-y-3 pt-4">
                                        <div class="grid grid-cols-2 gap-2">
                                            <button
                                                type="button"
                                                wire:click="saveAsDraft"
                                                class="w-full bg-gray-800 text-white py-2 px-4 rounded-md text-xs font-medium hover:bg-gray-900 transition-all duration-300"
                                            >
                                                Save Draft
                                            </button>
                                            <button
                                                type="button"
                                                onclick="confirm('Are you sure you want to discard changes?') || event.stopImmediatePropagation();"
                                                wire:click="clearForm"
                                                class="w-full border border-gray-300 text-gray-800 py-2 px-4 rounded-md text-xs font-medium hover:bg-gray-100 transition-all duration-300"
                                            >
                                                Discard
                                            </button>
                                        </div>
                                        <button
                                            type="submit"
                                            class="w-full bg-black text-white py-2 px-4 rounded-md text-xs font-medium hover:bg-gray-900 transition-all duration-300"
                                        >
                                            Update Announcement
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Preview -->
                        <div class="lg:w-2/3">
                            <div class="border border-gray-200 rounded-lg p-6 bg-white shadow-sm">
                                <h2 class="text-sm font-semibold text-gray-800 mb-6">Announcement Preview</h2>

                                <div class="border border-gray-200 rounded-md overflow-hidden">
                                    <!-- Cover Image Preview -->
                                    <div class="relative">
                                        <img
                                            src="{{ $coverImageUrl ?? ($existingCover ? Storage::url($existingCover) : 'https://via.placeholder.com/600x400?text=No+Cover+Image') }}"
                                            alt="Announcement cover"
                                            class="w-full h-48 object-cover"
                                        >
                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center p-6">
                                            <div class="text-white">
                                                <div class="flex items-center gap-3 text-xs mb-3">
                                                    <span class="bg-gray-800 bg-opacity-75 px-2 py-1 rounded">Announcement</span>
                                                    <span>{{ $formattedDate }}</span>
                                                    <span
                                                        class="{{ $status === 'published' ? 'bg-green-500' : 'bg-yellow-500' }} bg-opacity-75 px-2 py-1 rounded capitalize">
                        {{ $status }}
                    </span>
                                                </div>
                                                <h1 class="text-lg font-bold">{{ $title ?: 'Announcement Title Here' }}</h1>
                                                <p class="text-xs mt-1">By: Election Committee</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="p-6 space-y-6">
                                        <!-- Content -->
                                        <div class="p-6 space-y-6">
                                <textarea
                                    wire:model.debounce.500ms="content"
                                    placeholder="Enter announcement text content"
                                    class="w-full min-h-[150px] border-0 focus:outline-none p-4 text-sm bg-gray-50 rounded-md {{ $contentError ? 'border border-red-500' : '' }}"
                                ></textarea>
                                            @error('content') <span
                                                class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        @if (count($mediaPreviews) > 0)
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                @foreach ($mediaPreviews as $media)
                                                    <div class="border border-gray-200 rounded-md overflow-hidden">
                                                        @if ($media['type'] === 'images')
                                                            <img src="{{ $media['temp_url'] ?? $media['path'] }}"
                                                                 alt="{{ $media['name'] }}"
                                                                 class="w-full h-48 object-cover">
                                                        @elseif ($media['type'] === 'videos')
                                                            <video controls class="w-full h-48 object-cover">
                                                                <source src="{{ $media['temp_url'] ?? $media['path'] }}"
                                                                        type="video/mp4">
                                                                Your browser doesn't support videos
                                                            </video>
                                                        @endif
                                                        <div class="p-3 bg-gray-50">
                                                            <p class="text-xs font-medium text-gray-800 truncate">
                                                                {{ $media['name'] }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 mt-1">
                                                                {{ $this->formatFileSize($media['size']) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Success Message -->
                @if (session()->has('message'))
                    <div class="mt-6 p-4 bg-green-100 text-green-700 rounded-md text-sm shadow-sm">
                        {{ session('message') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
