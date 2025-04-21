<div class="w-full bg-white p-6 rounded-lg shadow-md">
    <!-- Header with filters -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
        <div class="text-gray-600 text-sm mb-2 sm:mb-0">
            Showing {{ $reviews->count() }}/{{ $totalReviews }} results
        </div>
        <div class="flex items-center space-x-2">
            <label class="text-sm text-gray-500" for="filter-date">
                Filter by date:
            </label>
            <input
                wire:model.live="dateFilter"
                class="text-sm text-gray-500 bg-gray-100 px-3 py-1.5 rounded border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                id="filter-date"
                type="date"
            />
            <select
                wire:model.live="ratingFilter"
                class="text-sm text-gray-500 bg-gray-100 px-3 py-1.5 rounded border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
                <option value="">All Ratings</option>
                <option value="5">★★★★★</option>
                <option value="4">★★★★☆</option>
                <option value="3">★★★☆☆</option>
                <option value="2">★★☆☆☆</option>
                <option value="1">★☆☆☆☆</option>
            </select>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="space-y-4">
        @forelse($reviews as $review)
            <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-3">
                    <div class="flex items-center">
                        <img
                            alt="{{ $review->name ?? 'anonymous' }} profile picture"
                            class="w-10 h-10 rounded-full mr-3 object-cover"
                            src="{{ $review->user->profile_photo_url ?? asset('storage/assets/logo/usep_logo.jpg') }}"
                        />
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">
                                {{ $review->name ?? 'anonymous' }}
                            </div><div class=" text-gray-800 text-[10px]">
                                {{ $review->token ?? 'unverified' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $review->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($review->rating))
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @elseif($i == ceil($review->rating) && $review->rating != floor($review->rating))
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        @endfor
                        <span class="ml-1 text-xs text-gray-500">{{ number_format($review->rating, 1) }}</span>
                    </div>
                </div>
                <p class="mt-3 text-gray-700 text-sm">
                    {{ $review->message }}
                </p>
            </div>
        @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or check back later.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
        <div class="mt-4">
            {{ $reviews->links('evotar.components.pagination.tailwind-pagination') }}
        </div>
    @endif
</div>
