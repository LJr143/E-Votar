<x-app-layout mainClass="flex" page_title="- Announcement">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 min-h-screen">
            <div class="container mx-auto p-4" x-data="announcementApp()">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Announcement</h1>
                    <p class="text-[11px] text-gray-700" x-text="currentDate"></p>
                </div>


               <div>
                   <livewire:announcement.create-announcement/>
               </div>

                <!-- List of Announcements Section -->
                <div class="mt-8 border border-gray-200 rounded-md p-4 bg-white">

                    <div class="flex flex-wrap justify-between items-center gap-2 mb-4">
                        <h2 class="text-[14px] font-medium">List of Announcements</h2>
                        <div class="w-full md:w-[250px]">
                            <div class="flex items-center border bg-white text-black border-gray-300 rounded-md h-8 px-3">
                                    <span class="flex items-center">
                                        <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                                        </svg>
                                    </span>
                                <x-input type="text" x-model="searchQuery"
                                         class="text-[10px] bg-transparent border-0 focus:ring-0 focus:outline-none w-full px-2"
                                         placeholder="Search elections..." aria-label="Search">
                                </x-input>
                            </div>
                        </div>
                    </div>




                    <div class="flex items-center gap-4 mb-4">
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-[11px]"
                                :class="activeTab === 'all' ? 'bg-black text-white' : 'text-black'"
                                @click="activeTab = 'all'; carouselIndex = 0">
                            All
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-[11px]"
                                :class="activeTab === 'published' ? 'bg-black text-white' : 'text-black'"
                                @click="activeTab = 'published'; carouselIndex = 0">
                            Published
                        </button>
                        <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-[11px]"
                                :class="activeTab === 'draft' ? 'bg-black text-white' : 'text-black'"
                                @click="activeTab = 'draft'; carouselIndex = 0">
                            Drafts
                        </button>
                    </div>

                    <template x-if="filteredAnnouncements.length === 0">
                        <div class="border border-gray-200 rounded-md p-8 text-center">
                            <div class="flex justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 opacity-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </div>
                            <h3 class="text-[14px] font-medium mb-2">No announcements found</h3>
                            <p class="text-[12px] text-gray-500"
                               x-text="searchQuery.trim()? 'No announcements match your search criteria.'
                : activeTab !== 'all'? `There are no ${activeTab} announcements available.`
                : 'No announcements found.'"></p>
                        </div>
                    </template>

                    <template x-if="filteredAnnouncements.length > 0">
                        <div class="relative">
                            <!-- Horizontal slider for announcements -->
                            <div class="w-full overflow-hidden">
                                <div class="flex transition-transform duration-300 ease-in-out"
                                     :style="`transform: translateX(-${carouselIndex * 100}%);`">
                                    <template x-for="(chunk, i) in getAnnouncementChunks()" :key="i">
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 min-w-full flex-shrink-0">
                                            <template x-for="announcement in chunk" :key="announcement.id">
                                                <div class="border border-gray-200 rounded-md overflow-hidden">
                                                    <div class="relative h-40">
                                                        <img
                                                                :src="announcement.coverImage || 'https://via.placeholder.com/400x200'"
                                                                :alt="announcement.title"
                                                                class="w-full h-full object-cover"
                                                        />
                                                        <div class="absolute top-2 right-2">
                                          <span
                                                  class="px-2 py-1 rounded-full text-[11px]"
                                                  :class="announcement.status === 'published' ? 'bg-black text-white' : 'bg-white border border-gray-300 text-black'">
                                            <span x-text="announcement.status === 'published' ? 'Published' : 'Draft'"></span>
                                          </span>
                                                        </div>
                                                        <template x-if="announcement.media.length > 0">
                                                            <div class="absolute bottom-2 left-2 bg-black/70 text-white px-2 py-1 rounded-md text-[12px]">
                                                                <span x-text="`${announcement.media.length} media item${announcement.media.length > 1 ? 's' : ''}`"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                    <div class="p-3">
                                                        <h3 class="font-medium truncate text-[12px]" x-text="announcement.title"></h3>
                                                        <p class="text-[11px] text-gray-700">
                                                            <span class="font-medium">Publication Date:</span>
                                                            <span x-text="announcement.date ? formatDate(announcement.date) : 'Not set'"></span>
                                                            <span x-text="announcement.time"></span>
                                                        </p>
                                                        <div class="flex justify-between items-center mt-2">
                                                            <p class="text-[11px] text-gray-500">
                                                                Created: <span x-text="formatDate(announcement.createdAt)"></span>
                                                            </p>
                                                            <div class="flex space-x-2">

                                                                <!-- Edit button - This is the Livewire component trigger -->
                                                                <button
                                                                        class="p-1 hover:bg-gray-100 rounded-full edit-announcement-btn"
                                                                        @click="editAnnouncement(announcement.id)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                                </button>



                                                                <!-- Delete icon -->
                                                                <button class="p-1 hover:bg-gray-100 rounded-full" @click="deleteAnnouncement(announcement.id)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Carousel navigation buttons -->
                            <button
                                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 rounded-full bg-white shadow-md z-10 h-8 w-8 flex items-center justify-center border border-gray-300"
                                    @click="carouselIndex = Math.max(0, carouselIndex - 1)"
                                    :disabled="carouselIndex === 0"
                                    :class="{ 'opacity-50 cursor-not-allowed': carouselIndex === 0 }"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>

                            <button
                                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 rounded-full bg-white shadow-md z-10 h-8 w-8 flex items-center justify-center border border-gray-300"
                                    @click="carouselIndex = Math.min(Math.ceil(filteredAnnouncements.length / 3) - 1, carouselIndex + 1)"
                                    :disabled="carouselIndex >= Math.ceil(filteredAnnouncements.length / 3) - 1"
                                    :class="{ 'opacity-50 cursor-not-allowed': carouselIndex >= Math.ceil(filteredAnnouncements.length / 3) - 1 }"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

            </div>

            <!-- Livewire component - Make sure it's visible in the DOM -->
{{--            <div>--}}
{{--                <livewire:manage-announcements.edit-announcement />--}}
{{--            </div>--}}

        </div>
    </x-slot>
</x-app-layout>

