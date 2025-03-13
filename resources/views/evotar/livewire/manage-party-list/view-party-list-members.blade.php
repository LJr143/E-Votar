<div x-data="{ open: false }" x-cloak @view-party-list.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#35353A">
            <path d="M360-240ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q32 0 64.5 3.5T489-425q-13 17-22.5 35.5T451-351q-23-5-45.5-7t-45.5-2q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32h323q4 22 11 42t18 38H40Zm320-320q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113Zm-400 80q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0-80Zm320 440q34 0 56.5-20t23.5-60q1-34-22.5-57T680-360q-34 0-57 23t-23 57q0 34 23 57t57 23Zm0 80q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 23-5.5 43.5T818-198L920-96l-56 56-102-102q-18 11-38.5 16.5T680-120Z"/>
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
            class="bg-white p-6 rounded shadow-md w-full max-w-lg mx-4 sm:mx-6 md:mx-8 lg:mx-10"
        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">View Partylist Members</h2>
                    <p class="text-[10px] text-gray-500 italic">
                        Search and view members of the Progressive Party.
                    </p>
                </div>

                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="relative mb-4">
                <input
                    class="border border-gray-300 text-[10px] rounded-lg px-4 py-2 w-full focus:ring-black focus:border-black"
                    placeholder="Search partylist members"
                    type="text"/>
            </div>


            <h3 class="text-gray-600 font-semibold mb-2 text-left text-[11px]">
                PARTYLIST MEMBERS
            </h3>
            <div class="space-y-4 max-h-48 overflow-y-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img alt="Profile picture of Adedayo Bello" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/5Za61rg1a5HZz35FTRozsCgecghWKYvCHN1rC2He468.jpg" width="40"/>
                        <div>
                            <p class="font-semibold" style="font-size: 12px;">
                                Adedayo Bello
                            </p>
                            <p class="text-gray-500 text-sm" style="font-size: 11px;">
                                Position: Secretary
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img alt="Profile picture of Courtney Henry" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/cSAmeYZvMgVed_xox41X0XcL5tK_l9EMUYCCecN3Hps.jpg" width="40"/>
                        <div>
                            <p class="font-semibold" style="font-size: 12px;">
                                Courtney Henry
                            </p>
                            <p class="text-gray-500 text-sm" style="font-size: 11px;">
                                Position: Treasurer
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img alt="Profile picture of Blessing Olasile" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/C20YGbcA-SZSs-Vs9ZeLUkftSKoAXBRajSgHXwDI-b0.jpg" width="40"/>
                        <div>
                            <p class="font-semibold" style="font-size: 12px;">
                                Blessing Olasile
                            </p>
                            <p class="text-gray-500 text-sm" style="font-size: 11px;">
                                Position: Member
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img alt="Profile picture of John Doe" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/7-FmwgXV5J-wvNxfWlXRwc_h7oJY4rwh4J0R1nYY2RE.jpg" width="40"/>
                        <div>
                            <p class="font-semibold" style="font-size: 12px;">
                                John Doe
                            </p>
                            <p class="text-gray-500 text-sm" style="font-size: 11px;">
                                Position: Member
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img alt="Profile picture of Jane Smith" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/EX4AgQgL4dNN6E_Y_5tGHDVSFUN916sIflMtrr8ySnA.jpg" width="40"/>
                        <div>
                            <p class="font-semibold" style="font-size: 12px;">
                                Jane Smith
                            </p>
                            <p class="text-gray-500 text-sm" style="font-size: 11px;">
                                Position: Member
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img alt="Profile picture of Alex Johnson" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/G1k9kKDIk34jhX7BNja4PAc-Eibe6K7WDINz6jmAOVA.jpg" width="40"/>
                        <div>
                            <p class="font-semibold" style="font-size: 12px;">
                                Alex Johnson
                            </p>
                            <p class="text-gray-500 text-sm" style="font-size: 11px;">
                                Position: Member
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button class="text-gray-600 hover:text-gray-800 text-[11px]"
                        @click="open = false">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
