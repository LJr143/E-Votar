<div class="mt-8 border border-gray-200 rounded-md p-4 bg-white">
    <!-- Search and Filter Section -->
    <div class="flex flex-wrap justify-between items-center gap-2 mb-4">
        <h2 class="text-[14px] font-medium">List of Announcements</h2>
        <div class="w-full md:w-[250px]">
            <div class="flex items-center border bg-white text-black border-gray-300 rounded-md h-8 px-3">
                <span class="flex items-center">
                    <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                    </svg>
                </span>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    class="text-[10px] bg-transparent border-0 focus:ring-0 focus:outline-none w-full px-2"
                    placeholder="Search announcements..."
                    aria-label="Search"
                >
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-4 mb-4">
        <button
            wire:click="filter = 'all'"
            class="px-3 py-1 border border-gray-300 rounded-md text-[11px]"
            :class="filter === 'all' ? 'bg-black text-white' : 'text-black'"
        >
            All
        </button>
        <button
            wire:click="filter = 'published'"
            class="px-3 py-1 border border-gray-300 rounded-md text-[11px]"
            :class="filter === 'published' ? 'bg-black text-white' : 'text-black'"
        >
            Published
        </button>
        <button
            wire:click="filter = 'draft'"
            class="px-3 py-1 border border-gray-300 rounded-md text-[11px]"
            :class="filter === 'draft' ? 'bg-black text-white' : 'text-black'"
        >
            Drafts
        </button>
    </div>

    <!-- Empty State -->
    @if ($announcements->isEmpty())
        <div class="border border-gray-200 rounded-md p-8 text-center">
            <div class="flex justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 opacity-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <h3 class="text-[14px] font-medium mb-2">No announcements found</h3>
            <p class="text-[12px] text-gray-500">
                @if($search)
                    No announcements match your search criteria.
                @elseif($filter !== 'all')
                    There are no {{ $filter }} announcements available.
                @else
                    No announcements found.
                @endif
            </p>
        </div>
    @else
        <!-- Announcements Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($announcements as $announcement)
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <div class="relative h-40">
                        <img
                            src="{{ $announcement->cover_image ? Storage::url($announcement->cover_image) : 'https://via.placeholder.com/400x200' }}"
                            alt="{{ $announcement->title }}"
                            class="w-full h-full object-cover"
                        />
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-1 rounded-full text-[11px] {{ $announcement->status === 'published' ? 'bg-black text-white' : 'bg-white border border-gray-300 text-black' }}">
                                {{ ucfirst($announcement->status) }}
                            </span>
                        </div>
                        @if($announcement->media && count(json_decode($announcement->media, true)) > 0)
                            <div class="absolute bottom-2 left-2 bg-black/70 text-white px-2 py-1 rounded-md text-[12px]">
                                {{ count(json_decode($announcement->media, true)) }} media item{{ count(json_decode($announcement->media, true)) > 1 ? 's' : '' }}
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium truncate text-[12px]">{{ $announcement->title }}</h3>
                        <p class="text-[11px] text-gray-700">
                            <span class="font-medium">Publication Date:</span>
                            {{ $announcement->publication_at ? \Carbon\Carbon::parse($announcement->publication_at)->format('M j, Y') : 'Not set' }}
                        </p>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-[11px] text-gray-500">
                                Created: {{ $announcement->created_at->format('M j, Y') }}
                            </p>
                            <div class="flex space-x-2">
                                <livewire:announcement.view-announcement :announcement="$announcement"/>

                               <livewire:announcement.edit-announcement :announcement="$announcement"/>

                                <!-- Delete button -->
                                <button
                                    wire:click="deleteAnnouncement('{{ $announcement->id }}')"
                                    wire:confirm="Are you sure you want to delete this announcement?"
                                    class="p-1 hover:bg-gray-100 rounded-full"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($announcements->hasPages())
            <div class="mt-4">
                {{ $announcements->links() }}
            </div>
        @endif
    @endif
</div>

@script
<script>
    // // Listen for edit event to open the edit form
    // Livewire.on('edit-announcement', (data) => {
    //     // You can implement this to open your edit modal/form
    //     console.log('Edit announcement:', data.id);
    //     // Example: $dispatch('open-edit-modal', {id: data.id})
    // });
</script>
@endscript
