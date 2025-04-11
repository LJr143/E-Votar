<div x-data="{ open: false }" x-cloak @election-updated.window="open = false" @open-modal.window="open = true">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
        <svg width="14" height="18" viewBox="0 0 17 17" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M1.49997 15.5H2.7615L12.9981 5.2634L11.7366 4.00188L1.49997 14.2385V15.5ZM0.90385 17C0.647767 17 0.433108 16.9133 0.259875 16.7401C0.0866248 16.5668 0 16.3522 0 16.0961V14.3635C0 14.1196 0.0467999 13.8871 0.1404 13.6661C0.233983 13.4451 0.362825 13.2526 0.526925 13.0885L13.1904 0.430775C13.3416 0.293426 13.5086 0.187292 13.6913 0.112375C13.874 0.0374582 14.0656 0 14.2661 0C14.4666 0 14.6608 0.0355838 14.8488 0.10675C15.0368 0.1779 15.2032 0.291034 15.348 0.44615L16.5692 1.68268C16.7243 1.82754 16.8349 1.99424 16.9009 2.18278C16.9669 2.37129 17 2.55981 17 2.74833C17 2.94941 16.9656 3.14131 16.8969 3.32403C16.8283 3.50676 16.719 3.67373 16.5692 3.82495L3.91147 16.473C3.74738 16.6371 3.55483 16.766 3.33383 16.8596C3.11281 16.9532 2.88037 17 2.6365 17H0.90385ZM12.3563 4.6437L11.7366 4.00188L12.9981 5.2634L12.3563 4.6437Z"
                fill="#35353A"/>
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
            class="bg-white p-6 rounded shadow-md w-full sm:w-3/5 mx-4 sm:mx-6 md:mx-8 lg:mx-10 xl:mx-12 overflow-y-auto max-h-[90vh]"

        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Edit Election</h2>
                    <p class="text-[10px] text-gray-500 italic">To edit an election please fill out the required
                        information.</p>
                </div>

                <!-- Close Button (X) -->
                <button @click="open = false; $dispatch('close-modal', { electionId: {{ $election->id }} })"
                        class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>


            </div>

            <!-- Election Details-->
            <form wire:submit.prevent="update">
                <div>
                    <div class="flex flex-col md:flex-row md:space-x-4">
                        <div class="flex-col w-full md:w-1/2">
                            <div class="mb-3">
                                <label for="election_name" class="text-xs font-semibold block mb-1">
                                    Name (eg. Student and Local Election 2023)</label>
                                <input id="election_name" type="text" placeholder="Student and Local Election 2023"
                                       class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full focus:ring-black focus:border-black"
                                       wire:model="election_name">

                                @error('election_name')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="election_type" class="text-xs font-semibold block mb-1">
                                    Election Type</label>
                                <select name="election_type" id="election_type" wire:model.live="election_type"
                                        class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full focus:ring-black focus:border-black" disabled>
                                    <option value="" selected>Select election type</option>
                                    @foreach($electionTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('election_type')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1 mb-3">
                                <label for="election_campus" class="text-xs font-semibold block mb-1">Campus</label>
                                <select name="election_campus" id="election_campus"
                                        class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full focus:ring-black focus:border-black"
                                        wire:model="election_campus">
                                    <option value="" selected>Select campus for election</option>
                                    @foreach($campus as $camp)
                                        <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                                    @endforeach
                                </select>
                                @error('election_campus')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Change the file input section -->
                            <div x-data="{
                                        isDragging: false,
                                        previewUrl: @entangle('temporaryImageEditUrl'),

                                        init() {
                                            window.addEventListener('imageUpdated', event => {
                                                this.previewUrl = event.detail.imageUrl;
                                            });
                                        },

                                        previewFile(event) {
                                            let file = event.target.files[0];
                                            if (file) {
                                                let reader = new FileReader();
                                                reader.onload = (e) => {
                                                    this.previewUrl = e.target.result;
                                                };
                                                reader.readAsDataURL(file);
                                            }
                                        }
                                    }"
                                 class="mt-4 w-full mb-3"
                                 wire:ignore>

                                <label class="block text-xs font-semibold mb-1">Election Image</label>

                                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center"
                                     x-bind:class="{ 'border-green-500 bg-green-50': isDragging }"
                                     @dragover.prevent="isDragging = true"
                                     @dragleave.prevent="isDragging = false"
                                     @drop.prevent="isDragging = false;
                                    $refs.fileInput.files = event.dataTransfer.files;
                                    $refs.fileInput.dispatchEvent(new Event('change'))"
                                     @click="$refs.fileInput.click()">

                                    <!-- File Preview -->
                                    <template x-if="previewUrl">
                                        <img :src="previewUrl" alt="Preview"
                                             class="w-full max-w-xs h-40 object-contain rounded-lg shadow-md">
                                    </template>

                                    <!-- Upload Icon & Message -->
                                    <div x-show="!previewUrl" class="text-center flex justify-center items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16v4m10-4v4M5 12h14M12 3v13m-3-3l3-3 3 3" />
                                        </svg>
                                        <p class="text-sm text-gray-500">Drag & Drop or Click to Upload</p>
                                    </div>

                                    <!-- Hidden File Input -->
                                    <input type="file" class="hidden" id="electionImageEdit" wire:model="electionImageEdit" x-ref="fileInput"
                                           @change="previewFile">

                                    <!-- Progress Bar -->
                                    <div wire:loading wire:target="electionImageEdit" class="w-full mt-2">
                                        <div class="h-2 bg-gray-300 rounded-full">
                                            <div class="h-2 bg-red-500 rounded-full animate-pulse" style="width: 100%;"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Uploading...</p>
                                    </div>
                                </div>

                                @error('electionImageEdit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>



                            <p class="text-[12px] font-medium">Election Period</p>
                            <div class="flex flex-col md:flex-row md:space-x-4 mb-4 border border-gray-300 rounded-md p-4">
                                <div class="flex-1 mb-3 md:mb-0 min-w-0">
                                    <label for="election_start" class="text-[10px] block mb-1">From</label>
                                    <input id="election_start" type="datetime-local"
                                           class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black"
                                           wire:model="election_start">
                                    @error('election_start')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex-1 min-w-0" wire:ignore>
                                    <label for="election_end" class="text-[10px] block mb-1">To</label>
                                    <input id="election_end" type="datetime-local"
                                           class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black"
                                           wire:model="election_end">
                                    @error('election_end')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex-col h-[530px] w-full md:w-1/2  overflow-auto">
                            <div class="mb-2">
                                <p class="text-xs font-semibold block mb-1">Election Positions</p>

                                <!-- Student Council Positions -->
                                @if(!empty($studentCouncilPositions))
                                    <p class="text-[11px] font-normal text-center mt-4 sm:mt-1 mb-2">Student Council Positions</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($studentCouncilPositions as $positionId => $positionName)
                                            @if(in_array($positionId, $selectedPositions))
                                                <!-- Only show selected positions -->
                                                <div
                                                    class="border border-gray-300 rounded-lg p-4 flex justify-between items-center w-full">
                                                    <span class="text-[10px]">{{ $positionName }}</span>
                                                    {{--                                                        <button type="button"--}}
                                                    {{--                                                                wire:click="removePosition({{ $positionId }})"--}}
                                                    {{--                                                                class="text-white px-2 py-1 rounded bg-red-500">--}}
                                                    {{--                                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"--}}
                                                    {{--                                                                 xmlns="http://www.w3.org/2000/svg">--}}
                                                    {{--                                                                <path d="M9 1L1 9M9 9L1 0.999998" stroke="white"--}}
                                                    {{--                                                                      stroke-width="2" stroke-linecap="round"/>--}}
                                                    {{--                                                            </svg>--}}
                                                    {{--                                                        </button>--}}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Local Council Positions -->
                                @if(!empty($localCouncilPositions) && $election_type != 2)
                                    <p class="text-[11px] font-normal text-center mb-2 mt-4">Local Council Positions</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($localCouncilPositions as $positionId => $positionName)
                                            @if(in_array($positionId, $selectedPositions))
                                                <!-- Only show selected positions -->
                                                <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center w-full">
                                                    <span class="text-[10px]">{{ $positionName }}</span>
                                                    {{--                                                    <button type="button"--}}
                                                    {{--                                                            wire:click="removePosition({{ $positionId }})"--}}
                                                    {{--                                                            class="text-white px-2 py-1 rounded bg-red-500">--}}
                                                    {{--                                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"--}}
                                                    {{--                                                             xmlns="http://www.w3.org/2000/svg">--}}
                                                    {{--                                                            <path d="M9 1L1 9M9 9L1 0.999998" stroke="white"--}}
                                                    {{--                                                                  stroke-width="2" stroke-linecap="round"/>--}}
                                                    {{--                                                        </svg>--}}
                                                    {{--                                                    </button>--}}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="mt-[-28px] pt-1 flex justify-end space-x-2">
                        <button type="button"
                                class="bg-white text-black text-[12px] border border-gray-300 h-7 px-4 py-1 rounded shadow-md hover:bg-gray-200 justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                @click="open = false">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                            Save Election
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
