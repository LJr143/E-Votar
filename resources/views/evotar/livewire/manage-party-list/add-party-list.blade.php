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

                <form wire:submit.prevent="submit">
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
