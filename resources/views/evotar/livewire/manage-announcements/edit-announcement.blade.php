<div x-data="announcementEditor()" @election-updated.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row items-center justify-items-center hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
        <svg width="14" height="18" viewBox="0 0 17 17" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M1.49997 15.5H2.7615L12.9981 5.2634L11.7366 4.00188L1.49997 14.2385V15.5ZM0.90385 17C0.647767 17 0.433108 16.9133 0.259875 16.7401C0.0866248 16.5668 0 16.3522 0 16.0961V14.3635C0 14.1196 0.0467999 13.8871 0.1404 13.6661C0.233983 13.4451 0.362825 13.2526 0.526925 13.0885L13.1904 0.430775C13.3416 0.293426 13.5086 0.187292 13.6913 0.112375C13.874 0.0374582 14.0656 0 14.2661 0C14.4666 0 14.6608 0.0355838 14.8488 0.10675C15.0368 0.1779 15.2032 0.291034 15.348 0.44615L16.5692 1.68268C16.7243 1.82754 16.8349 1.99424 16.9009 2.18278C16.9669 2.37129 17 2.55981 17 2.74833C17 2.94941 16.9656 3.14131 16.8969 3.32403C16.8283 3.50676 16.719 3.67373 16.5692 3.82495L3.91147 16.473C3.74738 16.6371 3.55483 16.766 3.33383 16.8596C3.11281 16.9532 2.88037 17 2.6365 17H0.90385ZM12.3563 4.6437L11.7366 4.00188L12.9981 5.2634L12.3563 4.6437Z"
                fill="#35353A"/>
        </svg>
    </button>

    <!-- Modal with teleport -->
    <template x-teleport="body">
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[99999]"
            style="position: fixed; top: 0; left: 0; right: 0; bottom: 0;"
            x-cloak
        >
            <div
                @click.outside="open = false"
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] mx-4 sm:mx-6 md:mx-8 lg:mx-10 xl:mx-12 overflow-y-auto p-6 z-[99999]"
            >
                <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                    <div>
                        <h2 class="text-sm font-bold text-left w-full sm:w-auto">Edit Announcement</h2>
                        <p class="text-[10px] text-gray-500 italic">To edit an announcement please fill out the required
                            information.</p>
                    </div>

                    <!-- Close Button (X) -->
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Edit Announcement Form -->
                <form @submit.prevent="validateAndSubmit()" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left side - Edit Form -->
                        <div class="space-y-4">
                            <div>
                                <label for="edit-title" class="block text-[12px] mb-1">
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input id="edit-title" type="text" placeholder="Enter announcement title"
                                       class="w-full px-3 py-2 border rounded-md text-[12px] focus:border-black focus:ring-black"
                                       :class="errors.title ? 'border-red-500' : 'border-gray-300'"
                                       x-model="formData.title">
                                <span class="text-red-500 text-[11px] mt-1" x-show="errors.title" x-text="errors.title"></span>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-black">
                                    Publication Date &amp; Time <span class="text-red-500">*</span>
                                </label>
                                <input class="mt-1 block w-full border rounded-md shadow-sm p-2 text-[12px] focus:border-black focus:ring-black"
                                       :class="errors.dateTime ? 'border-red-500' : 'border-gray-300'"
                                       id="edit-news-date-input"
                                       type="datetime-local"
                                       x-model="formData.dateTimeLocal">
                                <span class="text-red-500 text-[11px] mt-1" x-show="errors.dateTime" x-text="errors.dateTime"></span>
                            </div>

                            <div>
                                <label class="block text-[12px] mb-1">Cover</label>
                                <div class="border border-gray-200 rounded-md p-4 mb-2">
                                    <template x-if="formData.coverImageUrl">
                                        <div class="flex items-center">
                                            <img :src="formData.coverImageUrl" alt="Cover image" class="w-24 h-24 object-cover">
                                        </div>
                                    </template>
                                    <template x-if="!formData.coverImageUrl">
                                        <div class="text-[12px] text-gray-500">
                                            <img src="https://via.placeholder.com/24" alt="Cover image" class="w-6 h-6 object-cover inline mr-2">
                                            Cover image
                                        </div>
                                    </template>
                                </div>
                                <div class="flex items-center">
                                    <input type="file" id="edit-file-upload" class="hidden" @change="handleCoverImageChange($event)" accept="image/*">
                                    <label for="edit-file-upload" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-black py-1 px-3 rounded text-[11px] border border-gray-300">
                                        Choose File
                                    </label>
                                    <span class="ml-2 text-[11px] text-gray-500" x-text="formData.coverImageFile ? formData.coverImageFile.name : 'No file chosen'">No file chosen</span>
                                </div>
                                <span class="text-red-500 text-[11px] mt-1" x-show="errors.coverImage" x-text="errors.coverImage"></span>
                            </div>

                            <div>
                                <label class="block text-[12px] mb-1">Status <span class="text-red-500">*</span></label>
                                <div class="flex gap-4">
                                    <div class="flex items-center">
                                        <input type="radio" id="status-draft" name="status" class="mr-2" value="draft" x-model="formData.status">
                                        <label for="status-draft" class="text-[12px]">Draft</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="status-published" name="status" class="mr-2" value="published" x-model="formData.status">
                                        <label for="status-published" class="text-[12px]">Published</label>
                                    </div>
                                </div>
                                <span class="text-red-500 text-[11px] mt-1" x-show="errors.status" x-text="errors.status"></span>
                            </div>
                        </div>

                        <!-- Right side - Content and Media -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[12px] mb-1">Media</label>
                                <div class="border border-gray-200 rounded-md p-3 space-y-3">
                                    <template x-if="getMediaWithoutAttachments().length > 0">
                                        <template x-for="(item, index) in getMediaWithoutAttachments()" :key="item.id">
                                            <div class="relative border border-gray-200 rounded-md p-2">
                                                <button type="button" class="absolute top-2 right-2 h-6 w-6 rounded-full bg-white/80 hover:bg-white flex items-center justify-center" @click="removeMedia(item.id)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>

                                                <template x-if="item.type === 'image'">
                                                    <img :src="item.url" :alt="item.name" class="w-full h-auto max-h-[150px] object-contain rounded-md">
                                                </template>
                                                <template x-if="item.type === 'video'">
                                                    <div class="bg-gray-100 rounded-md p-4 flex items-center justify-center h-[150px]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                                        </svg>
                                                        <span class="text-[12px]" x-text="item.name"></span>
                                                    </div>
                                                </template>
                                                <p class="text-[11px] text-gray-500 mt-1" x-text="item.name"></p>
                                            </div>
                                        </template>
                                    </template>
                                    <template x-if="getMediaWithoutAttachments().length === 0">
                                        <p class="text-[12px] text-gray-500 text-center py-4">No media added yet</p>
                                    </template>
                                </div>

                                <div class="flex gap-2 mt-3">
                                    <input type="file" id="edit-media-image-upload" class="hidden" @change="handleMediaImageUpload($event)" accept="image/*">
                                    <button type="button" class="flex items-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-[11px] text-black hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" @click="document.getElementById('edit-media-image-upload').click()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                        <span>Image</span>
                                    </button>

                                    <input type="file" id="edit-media-video-upload" class="hidden" @change="handleMediaVideoUpload($event)" accept="video/*">
                                    <button type="button" class="flex items-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-[11px] text-black hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" @click="document.getElementById('edit-media-video-upload').click()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                        </svg>
                                        <span>Video</span>
                                    </button>

                                    <input type="file" id="edit-attachment-upload" class="hidden" @change="handleAttachmentUpload($event)" accept="*/*">
                                    <button type="button" class="flex items-center gap-1 px-3 py-1 border border-gray-300 rounded-md text-[11px] text-black hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" @click="document.getElementById('edit-attachment-upload').click()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                        </svg>
                                        <span>Attachment</span>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[12px] mb-1">Content <span class="text-red-500">*</span></label>
                                <textarea placeholder="Enter announcement text content"
                                          class="min-h-[200px] w-full border rounded-md p-4 resize-none text-[12px] focus:border-black focus:ring-black"
                                          :class="errors.content ? 'border-red-500' : 'border-gray-300'"
                                          x-model="formData.content"></textarea>
                                <span class="text-red-500 text-[11px] mt-1" x-show="errors.content" x-text="errors.content"></span>
                            </div>

                            <div>
                                <template x-if="getAttachments().length > 0">
                                    <div>
                                        <label class="block text-[12px] mb-1">Attachments</label>
                                        <div class="border border-gray-200 rounded-md p-3 space-y-2">
                                            <template x-for="attachment in getAttachments()" :key="attachment.id">
                                                <div class="flex items-center justify-between p-2 border border-gray-200 rounded-md">
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                                        </svg>
                                                        <div>
                                                            <p class="text-[12px]" x-text="attachment.name"></p>
                                                            <p class="text-[11px] text-gray-500" x-text="formatFileSize(attachment.size)"></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <a :href="attachment.url" download class="flex items-center gap-1 px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded text-[11px]">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                                            </svg>
                                                            <span>Download</span>
                                                        </a>
                                                        <button type="button" class="flex items-center justify-center h-6 w-6 rounded-full hover:bg-gray-100" @click="removeMedia(attachment.id)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                            </svg>
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

                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-[12px] text-black hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" @click="open = false">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md text-[12px] hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <script>
        function announcementEditor() {
            return {
                open: false,
                formData: {
                    title: '',
                    dateTimeLocal: '',
                    coverImageUrl: null,
                    coverImageFile: null,
                    status: 'draft',
                    content: '',
                    media: []
                },
                errors: {
                    title: null,
                    dateTime: null,
                    coverImage: null,
                    status: null,
                    content: null
                },

                // Handle cover image upload
                handleCoverImageChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.formData.coverImageFile = file;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.formData.coverImageUrl = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        this.formData.coverImageUrl = null;
                        this.formData.coverImageFile = null;
                    }
                },

                // Media handling methods
                getMediaWithoutAttachments() {
                    return this.formData.media.filter(item => !item.isAttachment);
                },

                getAttachments() {
                    return this.formData.media.filter(item => item.isAttachment);
                },

                handleMediaImageUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.formData.media.push({
                            id: Date.now(),
                            name: file.name,
                            url: URL.createObjectURL(file),
                            type: 'image',
                            isAttachment: false
                        });
                    }
                },

                handleMediaVideoUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.formData.media.push({
                            id: Date.now(),
                            name: file.name,
                            url: URL.createObjectURL(file),
                            type: 'video',
                            isAttachment: false
                        });
                    }
                },

                handleAttachmentUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.formData.media.push({
                            id: Date.now(),
                            name: file.name,
                            url: URL.createObjectURL(file),
                            size: file.size,
                            isAttachment: true
                        });
                    }
                },

                removeMedia(id) {
                    this.formData.media = this.formData.media.filter(item => item.id !== id);
                },

                formatFileSize(size) {
                    const units = ['B', 'KB', 'MB', 'GB'];
                    let index = 0;
                    while (size >= 1024 && index < units.length - 1) {
                        size /= 1024;
                        index++;
                    }
                    return `${size.toFixed(2)} ${units[index]}`;
                },

                // Form validation and submission
                validateAndSubmit() {
                    // Reset all errors
                    this.errors = {
                        title: null,
                        dateTime: null,
                        coverImage: null,
                        status: null,
                        content: null
                    };

                    let isValid = true;

                    // Validate title
                    if (!this.formData.title || this.formData.title.trim() === '') {
                        this.errors.title = 'Title is required';
                        isValid = false;
                    }

                    // Validate date and time
                    if (!this.formData.dateTimeLocal) {
                        this.errors.dateTime = 'Publication date and time are required';
                        isValid = false;
                    }

                    // Validate status
                    if (!this.formData.status) {
                        this.errors.status = 'Status is required';
                        isValid = false;
                    }

                    // Validate content
                    if (!this.formData.content || this.formData.content.trim() === '') {
                        this.errors.content = 'Announcement text content is required';
                        isValid = false;
                    }

                    if (isValid) {
                        // Form is valid, proceed with submission
                        this.submitForm();
                    } else {
                        // Scroll to the first error
                        this.$nextTick(() => {
                            const firstErrorElement = document.querySelector('.border-red-500');
                            if (firstErrorElement) {
                                firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        });
                    }
                },

                submitForm() {
                    // Here you would typically send the data to your server
                    console.log('Form submitted successfully with data:', this.formData);

                    // Show success message or close modal
                    alert('Announcement saved successfully!');
                    this.open = false;

                    // Reset form after submission if needed
                    this.resetForm();
                },

                resetForm() {
                    this.formData = {
                        title: '',
                        dateTimeLocal: '',
                        coverImageUrl: null,
                        coverImageFile: null,
                        status: 'draft',
                        content: '',
                        media: []
                    };
                    this.errors = {
                        title: null,
                        dateTime: null,
                        coverImage: null,
                        status: null,
                        content: null
                    };
                }
            };
        }
    </script>
</div>
