<div x-data="{ open: false }" x-cloak @election-created.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M11.4 21.6003H5.39999C4.0745 21.6003 2.99999 20.5258 3 19.2003L3.00009 4.80038C3.0001 3.4749 4.07462 2.40039 5.40009 2.40039H16.2004C17.5258 2.40039 18.6004 3.47491 18.6004 4.80039V9.60039M19.8 19.8004L21 21.0004M7.20037 7.20039H14.4004M7.20037 10.8004H14.4004M7.20037 14.4004H10.8004M20.4 17.4004C20.4 19.0572 19.0569 20.4004 17.4 20.4004C15.7431 20.4004 14.4 19.0572 14.4 17.4004C14.4 15.7435 15.7431 14.4004 17.4 14.4004C19.0569 14.4004 20.4 15.7435 20.4 17.4004Z"
                stroke="black" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round"/>
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
            class="bg-white p-6 rounded shadow-md max-w-full"
        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">View Election</h2>
                    <p class="text-[10px] text-gray-500 italic">
                        To view the details of the selected election, please refer to the information displayed below.
                    </p>
                </div>

                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Election Details-->
            <form>
                <div>
                    <div class="flex space-x-4">
                        <div class="flex-col">
                            <div class="mb-3">
                                <label for="election_name" class="text-xs font-semibold block mb-1 text-left">Name</label>
                                <input id="election_name" type="text" value="Election Name" wire:model="election_name"
                                       class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full bg-gray-100" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="election_type" class="text-xs font-semibold block mb-1 text-left">Election Type</label>
                                <input id="election_type" type="text" value="Selected election type" wire:model="election_type"
                                       class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full bg-gray-100" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="election_campus" class="text-xs font-semibold block mb-1 text-left">Campus</label>
                                <input id="election_campus" type="text" value="Selected Campus" wire:model="election_campus"
                                       class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full bg-gray-100" readonly>
                            </div>

                            <p class="text-[12px] font-medium text-left">Election Period</p>
                            <div class="flex flex-col md:flex-row md:space-x-4 mb-4 border border-gray-300 rounded-md p-4">
                                <div class="flex-1">
                                    <label for="election_start" class="text-xs font-semibold block mb-1 text-left">Date started</label>
                                    <input id="election_start" type="datetime-local" value="" wire:model="election_start"
                                           class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full bg-gray-100 focus:ring focus:ring-indigo-200 focus:outline-none" readonly>
                                </div>
                                <div class="flex-1">
                                    <label for="election_end" class="text-xs font-semibold block mb-1 text-left">Date ended</label>
                                    <input id="election_end" type="datetime-local" value="" wire:model="election_end"
                                           class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full bg-gray-100 focus:ring focus:ring-indigo-200 focus:outline-none" readonly>
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
                                class="flex items-center bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF"><path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/></svg>
                            Export Data
                        </button>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
