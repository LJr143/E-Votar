<div x-data="{ open: false }" x-cloak @party-list-created.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="w-[100px] mr-2 rounded py-[6px] px-2 bg-black text-white text-[10px] hover:bg-gray-700">
        Add Party List
    </button>
    <style>
        table td, th {
            font-size: 10px !important;
        }

        tr {
            height: 15px;
            line-height: 15px;
        }

        td, th {
            padding: 0;
        }

    </style>
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
            class="bg-white p-6 rounded shadow-md w-2/5 max-h-[700px]"
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
                                               class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full">
                                        @error('name')
                                        <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="mt-6 pt-3 flex justify-end space-x-2">
                            <button type="button"
                                    class="bg-gray-300 text-gray-700 text-[12px] h-7 px-4 py-1 rounded shadow-md hover:bg-gray-400 justify-center text-center"
                                    @click="open = false">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center">
                                Add Party List
                            </button>
                        </div>
                    </div>
                </form>

        </div>
    </div>
</div>
