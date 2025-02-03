<div>
    <div class="flex flex-col md:flex-row justify-between items-center mb-2">
        <div class="flex space-x-2">
            <button class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none">
                <svg width="12" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 1.25605V5.18007C11 5.71212 11 5.97814 11.109 6.18136C11.2049 6.36011 11.3578 6.50544 11.546 6.59652C11.7599 6.70007 12.0399 6.70007 12.6 6.70007H16.7305M6 13.35L9 16.2M9 16.2L12 13.35M9 16.2L9 10.5M11 1H5.8C4.11984 1 3.27976 1 2.63803 1.31063C2.07354 1.58387 1.6146 2.01987 1.32698 2.55613C1 3.16578 1 3.96385 1 5.56V15.44C1 17.0361 1 17.8342 1.32698 18.4439C1.6146 18.9801 2.07354 19.4161 2.63803 19.6894C3.27976 20 4.11984 20 5.8 20H12.2C13.8802 20 14.7202 20 15.362 19.6894C15.9265 19.4161 16.3854 18.9801 16.673 18.4439C17 17.8342 17 17.0362 17 15.44V6.7L11 1Z" stroke="#000000" stroke-width="1.8625" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none" onclick="toggleFilter()">
                <svg width="16" height="12" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.5 1.5H1.5L9.5 10.96V17.5L13.5 19.5V10.96L21.5 1.5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        <div class="flex flex-col sm:flex-row sm:justify-center gap-3 md:gap-3 w-full md:w-auto mt-2">
            <div class="relative sm:w-[250px] mb-4">
                <input type="text" wire:model.live="search" placeholder="Search..." aria-label="Search" class="rounded-md text-[10px] border bg-white text-black border-gray-300 h-8 pl-8 pr-4 focus:ring-1 focus:ring-black focus:border-black w-full">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <svg width="12" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                            </svg>
                        </span>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
            <tr class="w-full bg-black text-white uppercase text-[11px] leading-normal">
                <th class="py-3 px-6 text-left rounded-tl-lg border-b border-gray-300">
                    <input type="checkbox" class="form-checkbox h-4 w-4 text-black" wire:model="selectAll">
                </th>
                <th class="py-3 px-6 text-left border-b border-gray-300">User</th>
                <th class="py-3 px-6 text-left border-b border-gray-300">User ID</th>
                <th class="py-3 px-6 text-left border-b border-gray-300">Last Active</th>
                <th class="py-3 px-6 text-left rounded-tr-lg border-b border-gray-300"></th>
            </tr>
            </thead>
            <tbody class="text-black text-[12px] font-light">
            @forelse ($activeUsers as $user)
                <tr class="border-b border-gray-300 hover:bg-gray-100 cursor-pointer"
                    wire:click="selectUser({{ $user->id }})">
                    <td class="py-3 px-6 text-left">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-black row-checkbox">
                    </td>
                    <td class="py-3 px-6 text-left flex items-center">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <img alt="Profile picture" class="w-10 h-10 rounded-full" src="{{ asset('storage/assets/profile/cat_meme.jpg') }}">
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                            </div>
                            <div>
                                <p class="font-bold">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="text-gray-500 text-[11px]">{{ optional($user->roles->first())->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">{{ $user->id }}</td>
                    <td class="py-3 px-6 text-left">
                        <div class="font-bold">{{ \Carbon\Carbon::parse($user->last_activity)->format('d/m/Y') }}</div>
                        <div class="text-gray-500 text-[11px]">{{ \Carbon\Carbon::parse($user->last_activity)->format('h:i:s A') }}</div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="bg-gray-100 w-8 h-8 p-2 rounded-md cursor-pointer">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <rect opacity="0.3" x="3.50586" y="10.8213" width="1.64102" height="7.38461" rx="0.820512" transform="rotate(-90 3.50586 10.8213)" fill="#181C32"/>
                                <path d="M9.49067 14.3434C9.17024 14.6639 9.17024 15.1834 9.49067 15.5038C9.8111 15.8242 10.3306 15.8242 10.6511 15.5038L15.5741 10.5807C15.8848 10.2701 15.8956 9.76994 15.5988 9.44611L11.086 4.52303C10.7798 4.18899 10.2607 4.16642 9.92668 4.47263C9.59263 4.77884 9.57007 5.29787 9.87627 5.63192L13.8582 9.97587L9.49067 14.3434Z" fill="#181C32"/>
                            </svg>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-3 px-6 text-center text-gray-500">No active users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $activeUsers->links() }}
        </div>
    </div>

</div>
