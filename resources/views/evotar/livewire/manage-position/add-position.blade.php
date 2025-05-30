<div x-data="{ open: false }" x-cloak @position-created.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="w-[100px] mr-2 rounded py-[6px] px-2 bg-black text-white text-[12px] justify-center text-center  hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
        Add Position
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
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 px-4 sm:px-8"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-white p-6 rounded shadow-md w-[95%] sm:w-[75%] md:w-[50%] lg:w-2/5 max-h-[90vh] sm:max-h-[85vh] overflow-y-auto"
        >
            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">

            <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Add Position</h2>
                    <p class="text-[10px] text-gray-500 italic">To add an election position please provide the required
                        information.</p>
                </div>
                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="addPosition">
                <div>
                    <div class="flex space-x-4">
                        <div class="w-full">
                            <div class="mb-3 relative w-full">
                                <p class="text-[12px] font-semibold mb-2">Position Information</p>
                                <div class="flex-1 mb-3">
                                    <label for="name"
                                           class="text-[10px] font-natural px-2 block ">Position name</label>
                                    <input type="text" name="name" id="name" wire:model="name"
                                           class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full">
                                    @error('name')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex-1 mb-3">
                                    <label for="election_type_id" class="text-[10px] font-natural px-2 block">Election Type</label>
                                    <select wire:model="election_type_id" name="election_type_id"
                                            class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full">
                                        <option value="" selected>Select an election type</option>
                                        @foreach($election_types as $election_type)
                                            <option value="{{ $election_type->id }}">{{ $election_type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('election_type_id')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex-1 mb-3">
                                    <label for="num_winners"
                                           class="text-[10px] font-natural px-2 block ">No. of Winners</label>
                                    <input type="text" name="num_winners" id="num_winners" wire:model="num_winners"
                                           class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full">
                                    @error('num_winners')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="mt-6 pt-3 flex justify-end space-x-2">
                        <button type="button"
                                class="bg-gray-300 text-gray-700 text-[12px] h-7 px-4 py-1 rounded shadow-md hover:bg-gray-400 justify-center text-center hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                                @click="open = false">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                            Add Position
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
