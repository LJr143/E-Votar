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
            class="bg-white p-6 rounded shadow-md w-3/5"
        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">View Election</h2>
                    <p class="text-[10px] text-gray-500 italic">To edit an election please fill out the required
                        information.</p>
                </div>

                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>


        </div>
    </div>
</div>
