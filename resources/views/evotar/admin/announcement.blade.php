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


                <form>
                    <div class="flex flex-col lg:flex-row gap-2">
                        <!-- Left side - Create Announcement - 1/3 width -->
                        <div class="border border-gray-200 rounded-md p-4 bg-white lg:w-1/3">
                            <h2 class="text-[14px] font-medium mb-4">Create Announcement</h2>

                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-[12px] mb-1">
                                        Title
                                    </label>
                                    <input
                                            id="title"
                                            type="text"
                                            placeholder="Enter announcement title"
                                            class="w-full px-3 py-2 border rounded-md text-[12px] focus:border-black focus:ring-black"
                                            :class="titleError ? 'border-red-500' : 'border-gray-300'"
                                            x-model="title"
                                            @input="titleError = false"
                                    />
                                    <span class="text-red-500 text-[11px] mt-1" x-show="titleError">Title is required.</span>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-[12px] font-medium text-black">Publication Date &amp; Time</label>
                                    <input
                                            class="mt-1 block w-full border rounded-md shadow-sm p-2 text-[12px] focus:border-black focus:ring-black"
                                            :class="dateTimeError ? 'border-red-500' : 'border-gray-300'"
                                            id="news-date-input"
                                            type="datetime-local"
                                            x-model="dateTimeLocal"
                                            @change="updateDateTime()"
                                    />
                                    <span
                                            class="text-red-500 text-[11px] mt-1" x-show="dateTimeError">Publication date and time are required.</span>
                                </div>

                                <div>
                                    <label class="block text-[12px] mb-1">Cover</label>
                                    <div class="border border-gray-200 rounded-md p-4 mb-2">
                                        <template x-if="coverImageUrl">
                                            <div class="flex items-center">
                                                <img
                                                        :src="coverImageUrl"
                                                        alt="Cover image"
                                                        class="w-24 h-24 object-cover"
                                                />
                                            </div>
                                        </template>
                                        <template x-if="!coverImageUrl">
                                            <div class="text-[12px] text-gray-500">
                                                <img
                                                        src="https://via.placeholder.com/24"
                                                        alt="Cover image"
                                                        class="w-6 h-6 object-cover inline mr-2"
                                                />
                                                Cover image
                                            </div>
                                        </template>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                                type="file"
                                                id="file-upload"
                                                class="hidden"
                                                @change="handleFileChange($event)"
                                                accept="image/*"
                                        />
                                        <label for="file-upload" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-black py-1 px-3 rounded text-[11px] border border-gray-300">
                                            Choose File
                                        </label>
                                        <span class="ml-2 text-[11px] text-gray-500" x-text="selectedFile ? selectedFile : 'No file chosen'"></span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-[12px] mb-1">Media</label>
                                    <div class="flex gap-2 mb-2">
                                        <input
                                                type="file"
                                                id="media-image-upload"
                                                class="hidden"
                                                @change="handleMediaImageUpload($event)"
                                                accept="image/*"
                                        />
                                        <button
                                                class="flex items-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-[11px] text-black hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                                @click="document.getElementById('media-image-upload').click()"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                            <span>Images</span>
                                        </button>

                                        <input
                                                type="file"
                                                id="media-video-upload"
                                                class="hidden"
                                                @change="handleMediaVideoUpload($event)"
                                                accept="video/*"
                                        />
                                        <button class="flex items-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-[11px] text-black hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                                @click="document.getElementById('media-video-upload').click()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                                            <span>Video</span>
                                        </button>

                                        <input
                                                type="file"
                                                id="attachment-upload"
                                                class="hidden"
                                                @change="handleAttachmentUpload($event)"
                                                accept="*/*"
                                        />
                                        <button class="flex items-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-[11px] text-black hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                                @click="document.getElementById('attachment-upload').click()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                            <span>Attachment</span>
                                        </button>
                                    </div>

                                    <template x-if="getMediaWithoutAttachments().length > 0">
                                        <div class="border border-gray-200 rounded-md p-3 space-y-3 mb-4">
                                            <template x-for="(item, index) in getMediaWithoutAttachments()" :key="item.id">
                                                <div class="relative border border-gray-200 rounded-md p-2">
                                                    <button
                                                            class="absolute top-2 right-2 h-6 w-6 rounded-full bg-white/80 hover:bg-white flex items-center justify-center"
                                                            @click="removeMedia(item.id)"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                                    </button>

                                                    <template x-if="item.type === 'image'">
                                                        <img
                                                                :src="item.url"
                                                                :alt="item.name"
                                                                class="w-full h-auto max-h-[100px] object-contain rounded-md"
                                                        />
                                                    </template>
                                                    <template x-if="item.type === 'video'">
                                                        <div class="bg-gray-100 rounded-md p-2 flex items-center justify-center h-[100px]">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                                                            <span class="text-[11px]" x-text="item.name"></span>
                                                        </div>
                                                    </template>
                                                    <p class="text-[11px] text-gray-500 mt-1" x-text="item.name"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Attachments preview in left panel -->
                                    <template x-if="getAttachments().length > 0">
                                        <div class="border border-gray-200 rounded-md p-3 mb-4">
                                            <h3 class="text-[12px] font-medium mb-2">Attachments</h3>
                                            <div class="space-y-2">
                                                <template x-for="attachment in getAttachments()" :key="attachment.id">
                                                    <div class="relative border border-gray-200 rounded-md p-2">
                                                        <button class="absolute top-2 right-2 h-6 w-6 rounded-full bg-white/80 hover:bg-white flex items-center justify-center"
                                                                @click="removeMedia(attachment.id)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                                        </button>
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                                            <div>
                                                                <p class="text-[12px]" x-text="attachment.name"></p>
                                                                <p class="text-[11px] text-gray-500" x-text="formatFileSize(attachment.size)"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="space-y-2 mt-10">
                                    <div class="flex gap-2">
                                        <button class="w-full bg-black bg-opacity-70 text-white hover:bg-gray-800 py-2 px-4 rounded-md text-[11px] hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" @click="handleSaveAsDraft()">
                                            Save as Draft
                                        </button>
                                        <button class="w-full border border-gray-300 py-2 px-4 rounded-md text-[11px] text-black hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" @click="clearForm()">
                                            Clear
                                        </button>
                                    </div>
                                    <button class="w-full bg-black text-white hover:bg-gray-800 py-2 px-4 rounded-md text-[11px] hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" @click="handlePublish()">
                                        Publish
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right side - Announcement Text - 2/3 width -->
                        <div class="border border-gray-200 rounded-md p-4 bg-white lg:w-2/3">
                            <h2 class="text-[14px] font-medium mb-4">Announcement Text</h2>

                            <div class="border border-gray-200 rounded-md overflow-hidden mb-4">
                                <div class="mb-4 relative rounded overflow-hidden">
                                    <img
                                            :src="coverImageUrl || 'https://via.placeholder.com/600x400'"
                                            alt="Text cover image"
                                            class="w-full h-44 object-cover"
                                            width="600"
                                            height="250"
                                    />
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-8 z-10">
                                        <div class="container mx-auto py-8 md:px-4">
                                            <div class="flex items-center text-white space-x-4">
                                                <div class="text-[12px]">Announcement</div>
                                                <div class="text-[12px]" x-text="formattedDate"></div>
                                            </div>
                                            <div class="mt-4">
                                                <h1 class="text-[14px] font-bold text-white" x-text="title || 'Announcement title here'"></h1>
                                                <div class="text-[11px] text-white mt-2">
                                                    By: Election Committee
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <!-- Media preview (without attachments) -->
                                    <template x-if="getMediaWithoutAttachments().length > 0">
                                        <div class="mb-4 space-y-3">
                                            <template x-for="(item, index) in getMediaWithoutAttachments()" :key="item.id">
                                                <div class="relative border border-gray-200 rounded-md p-2">
                                                    <button
                                                            class="absolute top-2 right-2 h-6 w-6 rounded-full bg-white/80 hover:bg-white flex items-center justify-center"
                                                            @click="removeMedia(item.id)"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                                    </button>

                                                    <template x-if="item.type === 'image'">
                                                        <img
                                                                :src="item.url"
                                                                :alt="item.name"
                                                                class="w-full h-auto max-h-[100px] object-contain rounded-md"
                                                        />
                                                    </template>
                                                    <template x-if="item.type === 'video'">
                                                        <div class="bg-gray-100 rounded-md p-4 flex items-center justify-center h-[200px]">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                                                            <span class="text-[12px]" x-text="item.name"></span>
                                                        </div>
                                                    </template>
                                                    <p class="text-[11px] text-gray-500 mt-1" x-text="item.name"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <textarea placeholder="Enter announcement text content"
                                              class="min-h-[200px] w-full border-0 focus:outline-none px-8 py-4 resize-none text-[12px] focus:border-black focus:ring-black"
                                              :class="contentError ? 'border border-red-500 p-2' : ''"
                                              x-model="content"
                                              @input="contentError = false">
                                </textarea>
                                    <span class="text-red-500 text-[11px] mt-1 block" x-show="contentError">Announcement text content is required.</span>

                                    <!-- Attachments section below textarea -->
                                    <template x-if="getAttachments().length > 0">
                                        <div class="mt-4 border-t border-gray-200 pt-4">
                                            <h3 class="text-[12px] font-medium mb-2">Attachments</h3>
                                            <div class="space-y-2">
                                                <template x-for="attachment in getAttachments()" :key="attachment.id">
                                                    <div class="flex items-center justify-between p-2 border border-gray-200 rounded-md">
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                                                            <div>
                                                                <p class="text-[12px]" x-text="attachment.name"></p>
                                                                <p class="text-[11px] text-gray-500" x-text="formatFileSize(attachment.size)"></p>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <a :href="attachment.url" download class="flex items-center gap-1 px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded text-[11px]">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                                <span>Download</span>
                                                            </a>
                                                            <button class="flex items-center justify-center h-6 w-6 rounded-full hover:bg-gray-100" @click="removeMedia(attachment.id)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
            <div>
                <livewire:manage-announcements.edit-announcement />
            </div>

            <script>
                function announcementApp() {
                    return {
                        // Form states
                        title: "",
                        dateTimeLocal: "",
                        date: null,
                        time: "--:--",
                        dateTimeError: false,
                        titleError: false,
                        contentError: false,
                        selectedFile: null,
                        coverImageUrl: null,
                        content: "",
                        media: [],

                        time: "--:--",
                        dateTimeError: false,
                        titleError: false,
                        contentError: false,
                        selectedFile: null,
                        coverImageUrl: null,
                        content: "",
                        media: [],

                        // List states
                        announcements: [
                            {
                                id: "1",
                                title: "Announcement 1",
                                content: "Content....",
                                date: new Date(2024, 3, 20),
                                time: "09:30",
                                coverImage: "https://via.placeholder.com/400x200",
                                media: [
                                    { id: "m1", type: "image", url: "https://via.placeholder.com/600x400", name: "TOI 700 d illustration" },
                                ],
                                status: "published",
                                createdAt: new Date(2024, 3, 15),
                            },
                            {
                                id: "2",
                                title: "Announcement 2",
                                content: "Content....",
                                date: new Date(2024, 3, 25),
                                time: "14:00",
                                coverImage: "https://via.placeholder.com/400x200",
                                media: [
                                    { id: "m2", type: "image", url: "https://via.placeholder.com/600x400", name: "Mission patch" },
                                    { id: "m3", type: "video", url: "https://via.placeholder.com/600x400", name: "Mission animation" },
                                ],
                                status: "published",
                                createdAt: new Date(2024, 3, 18),
                            },
                            {
                                id: "3",
                                title: "Announcement 3",
                                content: "Content....",
                                date: new Date(2024, 4, 5),
                                time: "10:15",
                                coverImage: "https://via.placeholder.com/400x200",
                                media: [],
                                status: "draft",
                                createdAt: new Date(2024, 3, 22),
                            },
                            {
                                id: "4",
                                title: "Announcement 4",
                                content: "Content....",
                                date: new Date(2024, 4, 5),
                                time: "10:15",
                                coverImage: "https://via.placeholder.com/400x200",
                                media: [],
                                status: "draft",
                                createdAt: new Date(2024, 3, 22),
                            },
                            {
                                id: "5",
                                title: "Election Announcement",
                                content: "Content....",
                                date: new Date(2024, 4, 1),
                                time: "12:00",
                                coverImage: "https://via.placeholder.com/400x200/ffcc00/000000?text=Election+Announcement",
                                media: [],
                                status: "published",
                                createdAt: new Date(2024, 3, 30),
                            },
                        ],
                        isPreviewOpen: false,
                        activeTab: "all",
                        carouselIndex: 0,
                        searchQuery: "",

                        // Computed properties
                        get currentDate() {
                            return new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'numeric', day: 'numeric' });
                        },

                        get formattedDate() {
                            if (!this.date) return "Publication Date & Time";
                            return `${this.formatDate(this.date)} ${this.time !== "--:--" ? this.time : ""}`;
                        },

                        get filteredAnnouncements() {
                            return this.announcements
                                .filter(a => this.activeTab === "all" ? true : a.status === this.activeTab)
                                .filter(a => {
                                    if (!this.searchQuery.trim()) return true;
                                    const query = this.searchQuery.toLowerCase().trim();
                                    return a.title.toLowerCase().includes(query) || a.content.toLowerCase().includes(query);
                                });
                        },

                        // Methods
                        getAnnouncementChunks() {
                            const chunks = [];
                            const filtered = this.filteredAnnouncements;

                            for (let i = 0; i < filtered.length; i += 3) {
                                chunks.push(filtered.slice(i, i + 3));
                            }

                            return chunks;
                        },

                        formatDate(date) {
                            if (!date) return "";
                            const d = new Date(date);
                            return `${d.getMonth() + 1}/${d.getDate()}/${d.getFullYear()}`;
                        },

                        formatFileSize(bytes) {
                            if (!bytes) return "0 Bytes";
                            const k = 1024;
                            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                            const i = Math.floor(Math.log(bytes) / Math.log(k));
                            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                        },

                        getAttachments() {
                            return this.media.filter(item => item.type === 'attachment');
                        },

                        getMediaWithoutAttachments() {
                            return this.media.filter(item => item.type !== 'attachment');
                        },

                        updateDateTime() {
                            if (this.dateTimeLocal) {
                                this.date = new Date(this.dateTimeLocal);
                                this.time = this.dateTimeLocal.split('T')[1].substring(0, 5);
                                this.dateTimeError = false;
                            }
                        },

                        handleFileChange(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.selectedFile = file.name;
                                this.coverImageUrl = URL.createObjectURL(file);
                            }
                        },

                        handleMediaImageUpload(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const newMedia = {
                                    id: Date.now().toString(),
                                    type: "image",
                                    url: URL.createObjectURL(file),
                                    name: file.name
                                };
                                this.media.push(newMedia);
                                event.target.value = "";
                            }
                        },

                        handleMediaVideoUpload(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const newMedia = {
                                    id: Date.now().toString(),
                                    type: "video",
                                    url: URL.createObjectURL(file),
                                    name: file.name
                                };
                                this.media.push(newMedia);
                                event.target.value = "";
                            }
                        },

                        handleAttachmentUpload(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const newMedia = {
                                    id: Date.now().toString(),
                                    type: "attachment",
                                    url: URL.createObjectURL(file),
                                    name: file.name,
                                    size: file.size
                                };
                                this.media.push(newMedia);
                                event.target.value = "";
                            }
                        },

                        removeMedia(id) {
                            this.media = this.media.filter(m => m.id !== id);
                        },

                        validateForm() {
                            let isValid = true;

                            if (!this.title.trim()) {
                                this.titleError = true;
                                isValid = false;
                            }

                            if (!this.dateTimeLocal) {
                                this.dateTimeError = true;
                                isValid = false;
                            }

                            if (!this.content.trim()) {
                                this.contentError = true;
                                isValid = false;
                            }

                            return isValid;
                        },

                        handleSaveAsDraft() {
                            // Only validate the form, don't actually save
                            this.validateForm();
                        },

                        handlePublish() {
                            // Only validate the form, don't actually publish
                            this.validateForm();
                        },

                        clearForm() {
                            this.title = "";
                            this.content = "";
                            this.date = null;
                            this.time = "--:--";
                            this.dateTimeLocal = "";
                            this.dateTimeError = false;
                            this.titleError = false;
                            this.contentError = false;
                            this.selectedFile = null;
                            this.coverImageUrl = null;
                            this.media = [];

                            // Reset file inputs
                            document.getElementById('file-upload').value = "";
                            document.getElementById('media-image-upload').value = "";
                            document.getElementById('media-video-upload').value = "";
                            document.getElementById('attachment-upload').value = "";
                        },

                        deleteAnnouncement(id) {
                            if (confirm("Are you sure you want to delete this announcement?")) {
                                this.announcements = this.announcements.filter(a => a.id !== id);
                                // Reset carousel index if needed
                                const maxIndex = Math.ceil(this.filteredAnnouncements.length / 3) - 1;
                                if (this.carouselIndex > maxIndex) {
                                    this.carouselIndex = Math.max(0, maxIndex);
                                }
                            }
                        },

                        // Method to edit announcement and trigger Livewire component
                        editAnnouncement(id) {
                            // Find the announcement
                            const announcement = this.announcements.find(a => a.id === id);
                            if (!announcement) return;

                            // Directly call the Livewire component's method
                            if (typeof window.Livewire !== 'undefined') {
                                // Using Livewire's emit method to trigger the component
                                window.Livewire.emit('editAnnouncement', id);
                            }

                            // Fallback for testing - log the action
                            console.log(`Editing announcement: ${announcement.title} (ID: ${id})`);
                        },

                        viewAnnouncement(id) {
                            const announcement = this.announcements.find(a => a.id === id);
                            if (announcement) {
                                alert(`Viewing announcement: ${announcement.title}`);
                            }
                        }
                    };
                }

                // Add event listener to initialize Livewire component when the page loads
                document.addEventListener('DOMContentLoaded', function() {
                    // This ensures the Livewire component is properly initialized
                    if (typeof window.Livewire !== 'undefined') {
                        console.log('Livewire initialized');
                    }
                });
            </script>
        </div>
    </x-slot>
</x-app-layout>

