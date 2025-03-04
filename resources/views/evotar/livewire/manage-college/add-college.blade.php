<div x-data="{ open: false }" x-cloak @college-created.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="w-[100px] mr-2 rounded py-[6px] px-2 bg-black text-white text-[12px] hover:bg-gray-700">
        Add College
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
            class="bg-white p-6 rounded shadow-md w-1/3"
        >


            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Add College to {{ $campus->name }}</h2>
                    <p class="text-[10px] text-gray-500 italic">To add an college please fill out the required
                        information.</p>
                </div>

                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>


            <!-- College Details-->
            <form wire:submit.prevent="submit">
                <div>
                    <div class="mb-3">
                        <label for="name" class="text-xs font-semibold block mb-1">College Name <span
                                class="text-red-500">*</span></label>
                        <input id="name" type="text" placeholder="e.g. College of Education"
                               class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full"
                               wire:model="name">

                        @error('name')
                        <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-6 pt-3 flex justify-end space-x-2">
                        <button type="button"
                                class="bg-gray-300 text-gray-700 text-[12px] h-7 px-4 py-1 rounded shadow-md hover:bg-gray-400 justify-center text-center"
                                @click="open = false">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center">
                            Add
                        </button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
