<div x-data="{ open: false }" x-cloak @council-created.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true" class="w-[120px]  h-8 rounded bg-gradient-to-b from-gray-800 to-black text-white text-[12px] flex items-center justify-center gap-2 hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF">
            <path d="M444-444H240v-72h204v-204h72v204h204v72H516v204h-72v-204Z"/>
        </svg>
        Add Council
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
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Add Council</h2>
                    <p class="text-[10px] text-gray-500 italic">To add a council please provide the required
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
                                <p class="text-[12px] font-semibold mb-2">Council Information</p>
                                <div class="flex-1 mb-3">
                                    <label for="name"
                                           class="text-[10px] font-natural px-2 block ">Council name</label>
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
                                        <div class="w-32 h-32 flex-shrink-0 relative border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center">
                                            @if ($logo)
                                                <img src="{{ $logo->temporaryUrl() }}"
                                                     alt="Logo preview"
                                                     class="absolute inset-0 w-full h-full object-contain p-2" />
                                                <button wire:click="$set('logo', null)"
                                                        class="absolute top-1 right-1 bg-white/80 hover:bg-white rounded-full p-1 shadow-sm transition-all"
                                                        aria-label="Remove logo">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            @else
                                                <div class="text-center p-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
                                                        <span class="text-xs bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded transition">
                            Browse
                        </span>
                                                    </label>
                                                </div>

                                                @if($logo)
                                                    <button wire:click="$set('logo', null)"
                                                            type="button"
                                                            class="text-sm text-red-600 hover:text-red-800 flex items-center gap-1 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

                            <div class="mb-3 relative w-full" x-data="{ showInfo: false}">
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



                                <div class="w-full border border-black p-2 rounded-md">
                                    @foreach ($councilSettings as $index => $po)
                                        <div class="flex gap-2 items-center mb-2">
                                            <select name="councilSettings[{{ $index }}][position_id]"
                                                    wire:model.defer="councilSettings.{{ $index }}.position_id"
                                                    class="w-2/3 p-1 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 text-xs">
                                                <option value="">Select Position (Optional)</option>
                                                @foreach($electionTypesWithPositions as $electionType)
                                                    @if(count($electionType->positions) > 0)
                                                        <optgroup label="{{ $electionType->name }}">
                                                            @foreach($electionType->positions as $position)
                                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endif
                                                @endforeach
                                            </select>

                                            <select name="councilSettings[{{ $index }}][separated_by_major]"
                                                    wire:model.defer="councilSettings.{{ $index }}.separated_by_major"
                                                    class="w-1/3 p-1 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 text-xs">
                                                <option value="">Select Status</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>

                                            @if ($index > 0)
                                                <button type="button" wire:click="removeCouncilSettings({{ $index }})"
                                                        class="text-red-500 hover:text-red-700">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
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
                        <button wire:click="submit"
                                wire:loading.attr="disabled"
                                class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
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
