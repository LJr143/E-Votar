<div>
    <div class="flex flex-col lg:flex-row gap-8 container mx-auto px-4 py-8">
        <!-- Main Content (2/3 width on large screens) -->
        <div class="lg:w-2/3">
            <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('comelec-website.home') }}"
                   class="flex items-center hover:text-red-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Announcements
                </a>
            </div>

            <!-- Announcement Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Cover Image -->
                @if($coverImageUrl)
                    <div class="h-96 w-full overflow-hidden">
                        <img src="{{ $coverImageUrl }}" alt="Announcement cover" class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Announcement Content -->
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="flex justify-between items-center mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $announcement->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($announcement->status) }}
                    </span>

                        <!-- Sharing Buttons -->
                        <div class="flex space-x-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
                               target="_blank"
                               class="text-gray-500 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}"
                               target="_blank"
                               class="text-gray-500 hover:text-blue-400 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                            <a href="mailto:?subject={{ rawurlencode($shareTitle) }}&body={{ rawurlencode("Check out this announcement: $shareUrl") }}"
                               class="text-gray-500 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"/>
                                    <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Title and Date -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $announcement->title }}</h1>
                    <p class="text-gray-500 mb-6">
                        @if($announcement->publication_at)
                            {{ $formattedDate }}
                        @else
                            Not scheduled
                        @endif
                    </p>

                    <!-- Content -->
                    <div class="prose max-w-none mb-8">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>

                    <!-- Media Attachments -->
                    @if(count($mediaItems) > 0)
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Attachments</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($mediaItems as $media)
                                    <div class="border rounded-lg p-3 flex items-center hover:bg-gray-50 transition-colors">
                                        @if($media['type'] === 'images')
                                            <div class="mr-4 flex-shrink-0">
                                                <img src="{{ $media['url'] }}" alt="{{ $media['name'] }}" class="h-16 w-16 object-cover rounded">
                                            </div>
                                        @else
                                            <div class="mr-4 flex-shrink-0 bg-gray-100 p-3 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $media['name'] }}</p>
                                            <p class="text-sm text-gray-500">{{ $media['size'] }}</p>
                                            <a href="{{ $media['url'] }}" target="_blank"
                                               class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar (1/3 width on large screens) -->
        <div class="lg:w-1/3">
            <!-- Related Announcements -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Other Announcements</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($relatedAnnouncements as $related)
                        <a href="{{ route('comelec-website.selected-announcement', $related) }}"
                           class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                            <h4 class="font-medium text-gray-900">{{ $related->title }}</h4>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $related->publication_at ? $related->publication_at->format('M j, Y') : 'No date' }}
                            </p>
                        </a>
                    @empty
                        <div class="px-4 py-3 text-sm text-gray-500">No other announcements available</div>
                    @endforelse
                </div>
            </div>

            <!-- Share Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Share This Announcement</h3>
                </div>
                <div class="p-4">
                    <div class="flex justify-center space-x-4">
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
                           target="_blank"
                           class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>

                        <!-- Twitter -->
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}"
                           target="_blank"
                           class="bg-blue-400 text-white p-2 rounded-full hover:bg-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>

                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}"
                           target="_blank"
                           class="bg-blue-700 text-white p-2 rounded-full hover:bg-blue-800 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>

                        <!-- Email -->
                        <a href="mailto:?subject={{ rawurlencode($shareTitle) }}&body={{ rawurlencode("Check out this announcement: $shareUrl") }}"
                           class="bg-gray-600 text-white p-2 rounded-full hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"/>
                                <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Copy Link -->
                    <div class="mt-4">
                        <label for="share-link" class="block text-sm font-medium text-gray-700 mb-1">Direct Link</label>
                        <div class="flex">
                            <input type="text"
                                   id="share-link"
                                   value="{{ $shareUrl }}"
                                   readonly
                                   class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <button onclick="copyToClipboard('share-link')"
                                    class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function copyToClipboard(elementId) {
                const element = document.getElementById(elementId);
                element.select();
                element.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand('copy');

                // Show feedback
                const originalText = element.nextElementSibling.innerHTML;
                element.nextElementSibling.innerHTML = 'Copied!';
                setTimeout(() => {
                    element.nextElementSibling.innerHTML = originalText;
                }, 2000);
            }
        </script>
    @endpush
</div>
