<div x-data="{ open: false }" x-cloak @council-updated.window="open = false">
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
                    <h2 class="text-sm font-bold text-left text-black w-full sm:w-auto">Edit Council</h2>
                    <p class="text-[10px] text-gray-500 italic">To edit a council please provide the
                        required
                        information.</p>
                </div>
                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="editCouncil">
                <div>
                    <div class="flex flex-col space-y-4">
                        <div class="w-full">
                            <div class="mb-3 relative w-full">
                                <p class="text-[12px] font-semibold mb-2 text-black text-left">Council Information</p>
                                <div class="flex-1 mb-3">
                                    <label for="name"
                                           class="text-[10px] font-natural px-2 block text-black text-left ">Council
                                        name</label>
                                    <input type="text" name="name" wire:model="name"
                                           class="border border-gray-300 text-xs rounded-lg text-black px-4 py-2 w-full focus:ring-black focus:border-black">
                                    @error('name')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-6 relative" x-data="{ showInfo: false }">
                                    <div class="flex justify-between items-center mb-3">
                                        <div class="relative">
                                            <div class="flex items-center space-x-2">
                                                <h3 class="text-[12px] font-semibold text-gray-700">Voting Specifications</h3>

                                                <!-- Info Button -->
                                                <button type="button"
                                                        @click="showInfo = !showInfo"
                                                        class="text-gray-400 hover:text-gray-600 transition-colors"
                                                        aria-label="More information">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                                              clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Information Tooltip -->
                                            <div x-show="showInfo"
                                                 x-transition
                                                 class="absolute z-10 right-0 mt-1 w-64 bg-white border border-gray-200 rounded-lg shadow-lg p-3 text-xs">
                                                <h4 class="font-medium text-gray-800 mb-1">Voting Configuration</h4>
                                                <p class="text-gray-600 mb-2">Define how each position should be elected in this
                                                    council.</p>

                                                <ul class="space-y-2">
                                                    <li>
                                                        <span class="font-medium">Position:</span>
                                                        <span class="text-gray-600">Select the role to configure</span>
                                                    </li>
                                                    <li>
                                                        <span class="font-medium">Separated by Major:</span>
                                                        <ul class="mt-1 pl-3 space-y-1">
                                                            <li class="flex items-start">
                                                                <span class="text-green-600 mr-1">✓</span>
                                                                <span class="text-gray-600">Yes: Only same-major students can vote</span>
                                                            </li>
                                                            <li class="flex items-start">
                                                                <span class="text-red-600 mr-1">✗</span>
                                                                <span class="text-gray-600">No: Open to all students</span>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Add Specification Button -->
                                        <button type="button"
                                                wire:click="addCouncilSettings"
                                                class="px-3 py-1 bg-green-100 text-green-700 hover:bg-green-200 rounded-md text-xs transition-colors">
                                            + Add Specification
                                        </button>
                                    </div>

                                    <!-- Specifications Container -->
                                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                                        @forelse ($councilSettings as $index => $setting)
                                            <div class="flex items-center space-x-4 mb-4 last:mb-0 group">
                                                <!-- Position Select -->
                                                <div class="flex-1">
                                                    <label class="block text-[10px] text-gray-500 mb-1">Position</label>
                                                    <select wire:model.defer="councilSettings.{{ $index }}.position_id"
                                                            class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-red-300 focus:border-red-400">
                                                        <option value="">Select Position</option>
                                                        @foreach($electionTypesWithPositions as $electionType)
                                                            @if(count($electionType->positions) > 0)
                                                                <optgroup label="{{ $electionType->name }}">
                                                                    @foreach($electionType->positions as $position)
                                                                        <option
                                                                            value="{{ $position->id }}">{{ $position->name }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error("councilSettings.{$index}.position_id")
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Major Separation Toggle -->
                                                <div class="w-32">
                                                    <label class="block text-[10px] text-gray-500 mb-1">Major
                                                        Separation</label>
                                                    <select
                                                        wire:model.defer="councilSettings.{{ $index }}.separated_by_major"
                                                        class="w-full p-2 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-red-300">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                    @error("councilSettings.{$index}.separated_by_major")
                                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <!-- Delete Button (for non-first items) -->
                                                @if($index > 0)
                                                    <button type="button"
                                                            wire:click="removeCouncilSettings({{ $index }})"
                                                            class="mt-6 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity"
                                                            aria-label="Remove specification">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="text-center py-4 text-sm text-gray-500">
                                                No voting specifications added yet
                                            </div>
                                        @endforelse
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
                        <button wire:click="editCouncil"
                                wire:loading.attr="disabled"
                                class="px-4 py-1 bg-black text-white rounded-md hover:bg-red-700  hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                            <span wire:loading.remove wire:target="editCouncil" class="tex-[12px]">Save Changes</span>
                            <span wire:loading wire:target="editCouncil">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
