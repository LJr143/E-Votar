<div>
    <div class="flex flex-col md:flex-row justify-between items-center mb-2">
        <div class="flex space-x-2">
        </div>
        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 md:gap-3 w-full md:w-auto mt-2">
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
    <div class="min-h-[400px] overflow-x-auto">
        <table class="min-w-full">
            <thead>
            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal whitespace-nowrap">
                <th class="py-3 px-6 text-left border-b border-gray-300">User</th>
                <th class="py-3 px-6 text-left border-b border-gray-300">User ID</th>
                <th class="py-3 px-6 text-left border-b border-gray-300">Last Active</th>
                <th class="py-3 px-6 text-left rounded-tr-lg border-b border-gray-300"></th>
            </tr>
            </thead>
            <tbody class="text-black text-[12px] font-light">
            @forelse ($activeUsers as $user)
                <tr class="border-b border-gray-300 cursor-pointer whitespace-nowrap"
                    wire:click="selectUser({{ $user->id }})"
                    x-on:click="$dispatch('user-selected')">
                    {{--                    <td class="py-3 px-6 text-left">--}}
                    {{--                        <input type="checkbox" class="form-checkbox h-4 w-4 text-black row-checkbox">--}}
                    {{--                    </td>--}}
                    <td class="py-3 px-2 sm:px-6 text-left">
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <div class="relative flex-shrink-0">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden">
                                    <img
                                        alt="Profile picture"
                                        class="w-full h-full object-cover"
                                        src="{{ asset('storage/' . ($user->profile_photo_path ?? 'assets/profile/default.jpg')) }}"
                                    >
                                </div>
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
            {{ $activeUsers->links('evotar.components.pagination.tailwind-pagination') }}
        </div>
    </div>
</div>
