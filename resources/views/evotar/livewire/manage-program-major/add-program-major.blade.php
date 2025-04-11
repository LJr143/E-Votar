<div x-data="{ open: false }" x-cloak @program-major-created.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="w-[120px] sm:w-[140px] md:w-[160px] lg:w-[180px] mr-2 rounded py-[6px] px-2 bg-black text-white text-[12px]  hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
            Add Program Major
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
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 px-4"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-white p-6 rounded shadow-md w-full max-w-md sm:w-3/4 md:w-2/3 lg:w-1/3"
        >
            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Add Program Major to {{ $program->name }}</h2>
                    <p class="text-[10px] text-gray-500 italic">To add an program major please fill out the required
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
                        <label for="name" class="text-xs font-semibold block mb-1">Program Major Name <span
                                class="text-red-500">*</span></label>
                        <input id="name" type="text" placeholder="e.g. Bachelor of Science in Information Security"
                               class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full"
                               wire:model="name">

                        @error('name')
                        <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-6 pt-3 flex justify-end space-x-2">
                        <button type="button"
                                class="bg-gray-300 text-gray-700 text-[12px] h-7 px-4 py-1 rounded shadow-md hover:bg-gray-400 justify-center text-center  hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                @click="open = false">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center  hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                            Add
                        </button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
