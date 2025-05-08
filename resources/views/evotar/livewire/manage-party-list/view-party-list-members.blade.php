<div x-data="{ open: false }" x-cloak @view-party-list.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row items-center justify-items-center hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
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
            class="bg-white p-6 rounded shadow-md w-full max-w-lg mx-4 sm:mx-6 md:mx-8 lg:mx-10 xl:mx-12"
        >
            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">View Party list Members {{ $partyList->name ?? '' }}</h2>
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
                    class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full focus:outline-black"
                    placeholder="Search partylist members"
                    type="text"
                    wire:model.live="search"
                />
            </div>

            <h3 class="text-gray-600 font-semibold mb-2" style="font-size: 11px;">
                PARTY LIST MEMBERS
            </h3>

            <div class="space-y-4 max-h-48 overflow-y-auto">
                @foreach($candidates as $candidate)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img
                                alt="{{ $candidate->users->first_name }}"
                                class="w-6 h-6 rounded-full border-2 border-white"
                                src="{{ $candidate->users->profile_photo_path ? asset('storage/' . $candidate->users->profile_photo_path) : asset('storage/assets/profile/default.jpg') }}"
                                width="30"
                                height="30"
                            />
                            <div>
                                <p class="font-semibold" style="font-size: 12px;">
                                    {{ $candidate->users->first_name . ' ' . $candidate->users->last_name }}
                                </p>
                                <p class="text-gray-500 text-sm" style="font-size: 11px;">
                                    {{ $candidate->users->program->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                    <!-- Empty State -->
                    @if ($candidates->isEmpty())
                        <div class="border border-gray-200 rounded-md p-8 text-center">
                            <div class="flex justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 opacity-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </div>
                            <h3 class="text-[14px] font-medium mb-2">No members found</h3>
                            <p class="text-[12px] text-gray-500">
                                @if($search)
                                    No members match your search criteria.
                                @else
                                    No members found.
                                @endif
                            </p>
                        </div>
                    @endif
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <button @click="open = false" class="text-gray-600 bg-white border border-gray-300 h-7 px-4 py-1 rounded shadow-md hover:text-gray-800 hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110" style="font-size: 11px;">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
