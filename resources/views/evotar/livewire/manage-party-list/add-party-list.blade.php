<div x-data="{ open: false }" x-cloak @party-list-created.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true" class="w-[120px]  h-8 mr-2 rounded bg-gradient-to-b from-gray-800 to-black text-white text-[12px] flex items-center justify-center gap-2 hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF">
            <path d="M444-444H240v-72h204v-204h72v204h204v72H516v204h-72v-204Z"/>
        </svg>
        Add Party List
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
            class="bg-white p-6 rounded shadow-md w-11/12 sm:w-2/5 max-h-[700px] overflow-y-auto"
        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Add Party List</h2>
                    <p class="text-[10px] text-gray-500 italic">To add a election party list please provide the required
                        information.</p>
                </div>
                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

                <form wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div>
                        <div class="flex space-x-4">
                            <div class="w-full">
                                <div class="mb-3 relative w-full">
                                    <p class="text-[12px] font-semibold mb-2">Party List Information</p>
                                    <div class="flex-1 mb-3">
                                        <label for="name"
                                               class="text-[10px] font-natural px-2 block ">Party list name</label>
                                        <input type="text" name="name" wire:model="name"
                                               class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full focus:ring-black focus:border-black">
                                        @error('name')
                                        <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="logo" class="block text-[10px] font-medium mb-2">Upload Logo</label>

                                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                                            <!-- Preview Container -->
                                            <div
                                                class="w-32 h-32 flex-shrink-0 relative border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                                                @if ($logo)
                                                    <img src="{{ $logo->temporaryUrl() }}"
                                                         alt="Logo preview"
                                                         class="absolute inset-0 w-full h-full object-contain p-2"/>
                                                    <button wire:click="$set('logo', null)"
                                                            class="absolute top-1 right-1 bg-white/80 hover:bg-white rounded-full p-1 shadow-sm transition-all"
                                                            aria-label="Remove logo">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                @else
                                                    <div class="text-center p-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="h-10 w-10 mx-auto text-gray-400" fill="none"
                                                             viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="1.5"
                                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <p class="text-xs text-gray-500 mt-1">No logo selected</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Upload Controls -->
                                            <div class="flex-1 w-full min-w-0">
                                                <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                                                    <div class="relative flex-1 w-full">
                                                        <input type="file"
                                                               id="logo"
                                                               wire:model="logo"
                                                               accept="image/*"
                                                               class="block w-full text-sm text-gray-700 file:hidden border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition h-10 px-3 py-2">

                                                        <label for="logo"
                                                               class="absolute inset-0 flex items-center justify-between px-3 py-2 bg-white border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <span class="text-sm text-gray-500 truncate mr-2">
                            {{ $logo ? $logo->getClientOriginalName() : 'Choose a file...' }}
                        </span>
                                                            <span
                                                                class="text-xs bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded transition">
                            Browse
                        </span>
                                                        </label>
                                                    </div>

                                                    @if($logo)
                                                        <button wire:click="$set('logo', null)"
                                                                type="button"
                                                                class="text-sm text-red-600 hover:text-red-800 flex items-center gap-1 transition">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Remove
                                                        </button>
                                                    @endif
                                                </div>

                                                @error('logo')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror

                                                <p class="mt-2 text-xs text-gray-500">
                                                    Recommended: Square image (1:1 aspect ratio), 300×300 pixels minimum
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="mt-6 pt-3 flex justify-end space-x-2">
                            <button type="button"
                                    class="bg-white text-black text-[12px] border border-gray-300 h-7 px-4 py-1 rounded shadow-md hover:bg-gray-200 justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                    @click="open = false">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                Add Party List
                            </button>
                        </div>
                    </div>
                </form>

        </div>
    </div>
</div>
