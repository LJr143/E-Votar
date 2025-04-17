<div class="w-full">
    <!-- Livewire Component -->
    <div wire:init="loadAnnouncements" class="relative">
        <!-- Navigation Arrows -->
        <button wire:click="previous"
                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md hover:shadow-lg transition-all duration-300 ml-2"
                :disabled="$currentIndex === 0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <button wire:click="next"
                class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md hover:shadow-lg transition-all duration-300 mr-2"
                :disabled="$currentIndex >= $totalAnnouncements - $visibleSlides">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Announcements Carousel -->
        <div class="overflow-hidden w-full h-[340px]">
            <div class="flex transition-transform duration-500 ease-in-out"
                 style="transform: translateX(-{{ $currentIndex * (100 / $visibleSlides) }}%)">
                @forelse($announcements as $announcement)
                    <div class="flex-shrink-0 w-full sm:w-1/2 lg:w-1/3 px-2" style="width: {{ 100 / $visibleSlides }}%">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 h-full flex flex-col">
                            <a href="{{ route('comelec-website.selected-announcement', $announcement['id']) }}" class="block">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $announcement['cover_image'] ? Storage::url($announcement['cover_image']) : asset('images/default-announcement.jpg') }}"
                                         alt="{{ $announcement['title'] }}"
                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                    <div class="absolute bottom-0 left-0 bg-gradient-to-t from-black/70 to-transparent w-full p-4">
                                        <span class="bg-white text-xs font-semibold px-2 py-1 rounded text-gray-800">
                                            {{ ucfirst($announcement['status']) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5 flex-grow flex flex-col">
                                    <div class="flex-grow">
                                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 hover:text-red-600 transition-colors">
                                            {{ $announcement['title'] }}
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                            {{ Str::limit(strip_tags($announcement['content']), 120) }}
                                        </p>
                                    </div>
                                    <div class="flex justify-between items-center mt-auto">
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                            {{ $announcement['campus'] ?? 'All Campuses' }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($announcement['publication_at'])->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No announcements yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Check back later for updates</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination Indicators -->
        @if($announcements->count() > $visibleSlides)
            <div class="flex justify-center mt-4 space-x-2">
                @foreach(range(0, ceil($announcements->count() / $visibleSlides) - 1) as $page)
                    <button wire:click="goToPage({{ $page }})"
                            class="w-3 h-3 rounded-full transition-all {{ $currentIndex / $visibleSlides == $page ? 'bg-red-600 w-6' : 'bg-gray-300' }}">
                    </button>
                @endforeach
            </div>
        @endif
    </div>
    <script>
        function getVisibleSlidesCount() {
            if (window.innerWidth < 640) return 1;
            if (window.innerWidth < 1024) return 2;
            return 3;
        }

        document.addEventListener('livewire:init', () => {
            // Initial check
            Livewire.dispatch('window-resized', { visibleSlides: getVisibleSlidesCount() });

            // Update on resize
            window.addEventListener('resize', () => {
                Livewire.dispatch('window-resized', { visibleSlides: getVisibleSlidesCount() });
            });
        });
    </script>
</div>
