<div x-data="{ open: false }" x-cloak @party-list-updated.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
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
            class="bg-white p-6 rounded shadow-md w-full max-w-lg mx-4 sm:mx-6 md:mx-8 lg:mx-auto max-h-[700px]"
        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left text-black w-full sm:w-auto">Edit Party List</h2>
                    <p class="text-[10px] text-gray-500 italic">To edit a election party list please provide the
                        required
                        information.</p>
                </div>
                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="editPartyList">
                <div>
                    <div class="flex flex-col space-y-4">
                        <div class="w-full">
                            <div class="mb-3 relative w-full">
                                <p class="text-[12px] font-semibold mb-2 text-black text-left">Party List Information</p>
                                <div class="flex-1 mb-3">
                                    <label for="name"
                                           class="text-[10px] font-natural px-2 block text-black text-left ">Party list name</label>
                                    <input type="text" name="name" wire:model="name"
                                           class="border border-gray-300 text-xs rounded-lg text-black px-4 py-2 w-full focus:ring-black focus:border-black">
                                    @error('name')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Party List Logo</label>
                                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                                        <!-- Preview Container -->
                                        <div class="w-32 h-32 flex-shrink-0 relative border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                                            @if($temporaryLogoUrl && !$currentLogoUrl)
                                                <!-- Newly uploaded logo preview -->
                                                <img src="{{ $temporaryLogoUrl }}" alt="New logo preview" class="absolute inset-0 w-full h-full object-contain p-2" />
                                                <button type="button"
                                                        wire:click="removeLogo"
                                                        class="absolute top-1 right-1 bg-white/80 hover:bg-white rounded-full p-1 shadow-sm transition-all z-10">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            @elseif($currentLogoUrl)
                                                <!-- Existing saved logo -->
                                                <img src="{{ asset('storage/'. $currentLogoUrl) }}" alt="Current logo" class="absolute inset-0 w-full h-full object-contain p-2" />
                                                <button type="button"
                                                        wire:click="removeLogo"
                                                        class="absolute top-1 right-1 bg-white/80 hover:bg-white rounded-full p-1 shadow-sm transition-all z-10">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            @else
                                                <!-- Placeholder when no logo exists -->
                                                <div class="text-center p-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <p class="text-xs text-gray-500 mt-1">No logo</p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Upload Controls -->
                                        <div class="flex-1 w-full min-w-0">
                                            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                                                <div class="relative flex-1 w-full overflow-hidden">
                                                    <input type="file"
                                                           id="logo-upload-{{ $partyList->id }}"
                                                           wire:model="logo"
                                                           accept="image/*"
                                                           class="sr-only">
                                                    <label for="logo-upload-{{ $partyList->id }}"
                                                           class="block w-full h-10 px-3 py-2 bg-white border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition flex items-center justify-between">
                                                    <span class="text-sm text-gray-500 truncate mr-2">
                                                        @if($logo)
                                                            {{ $logo->getClientOriginalName() }}
                                                        @else
                                                            Choose a new logo...
                                                        @endif
                                                    </span>
                                                        <span class="text-xs bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded transition">
                                                        Browse
                                                    </span>
                                                    </label>
                                                </div>

                                                @if($currentLogoPath)
                                                    <button type="button"
                                                            wire:click="removeLogo"
                                                            class="text-sm text-red-600 hover:text-red-800 flex items-center gap-1 transition px-3 py-2 border border-red-200 rounded-lg hover:bg-red-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Remove Logo
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
                            Save Party List
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
