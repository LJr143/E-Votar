<div x-data="{ open: false }" x-cloak>
    <!-- Trigger Button -->
    <button @click="open = true"  class="p-1 hover:bg-gray-100 rounded-full">
        <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
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
            class="bg-white p-6 rounded shadow-md w-2/5 max-h-[700px] overflow-y-auto"
        >
            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">{{ $announcement->title }}</h2>
                    <p class="text-[10px] text-gray-500 italic">
                        Published: {{ $announcement->publication_at ? \Carbon\Carbon::parse($announcement->publication_at)->format('M j, Y') : 'Not set' }}
                    </p>
                </div>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Cover Image -->
            @if($announcement->cover_image)
                <img src="{{ asset('storage/'.$announcement->cover_image) }}"
                     alt="Cover image"
                     class="w-full h-48 object-cover rounded-lg mb-4">
            @endif

            <!-- Content -->
            <div class="prose max-w-none text-xs mb-4">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            <!-- Media -->
            @if($announcement->media && count(json_decode($announcement->media, true)) > 0)
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-xs font-bold mb-2">Attachments</h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(json_decode($announcement->media, true) as $media)
                            @if($media['type'] === 'images')
                                <img src="{{ asset('storage/'.$media['path']) }}"
                                     alt="{{ $media['name'] }}"
                                     class="w-full h-32 object-cover rounded">
                            @elseif($media['type'] === 'videos')
                                <video controls class="w-full h-32 object-cover rounded">
                                    <source src="{{ asset('storage/'.$media['path']) }}" type="video/mp4">
                                </video>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-6 pt-3 flex justify-end">
                <button type="button"
                        class="bg-gray-300 text-gray-700 text-[12px] h-7 px-4 py-1 rounded shadow-md hover:bg-gray-400"
                        @click="open = false">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
