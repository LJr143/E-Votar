<div x-data="{ open: false }" x-cloak @voter-added.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="w-[110px] mr-2 rounded py-[6px] px-2 bg-black text-white text-[12px] hover:bg-gray-700">
        Add Voter
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
            class="bg-white p-6 rounded shadow-md w-2/5"
        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Add Voter</h2>
                    <p class="text-[10px] text-gray-500 italic">To add a voter please provide the required
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
                            <div class="mb-3 relative w-full" x-data="{ isOpen: false }">
                                <input
                                    type="text"
                                    id="name"
                                    placeholder="Search for a user"
                                    class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full"
                                    wire:model.live="search"
                                    x-on:focus="isOpen = true"
                                    x-on:blur="setTimeout(() => isOpen = false, 200)"
                                    autocomplete="off"
                                />
                                <div x-show="isOpen && search.length > 0" @click.away="isOpen = false"
                                     class="flex z-10 bg-white border border-gray-300 rounded-lg w-full max-h-[50px] overflow-auto mt-[5px] shadow-lg">
                                    <div class="w-full">
                                        @if (!empty($users))
                                            @forelse ($users as $user)
                                                <div
                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                                    wire:click="selectUser({{ $user->id }})"
                                                    x-on:click="isOpen = false"
                                                >
                                                    {{ $user->first_name }} {{ $user->middle_initial }}
                                                    . {{ $user->last_name }}
                                                    - {{ $user->year_level }} {{ $user->program->name }}
                                                </div>
                                            @empty
                                                <li class="px-4 py-2 text-gray-500">No results found.</li>
                                            @endforelse
                                        @endif
                                    </div>
                                </div>

                                @error('selectedUser')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 relative w-full">
                                <p class="text-[12px] font-semibold my-2">Account Information</p>
                                <div class="flex-1 mb-3">
                                    <label for="username"
                                           class="text-[10px] font-natural px-2 block ">Username</label>
                                    <input type="text" name="username" wire:model="username"
                                           class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full">
                                    @error('username')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex-1 mb-3">
                                    <label for="password"
                                           class="text-[10px] font-natural px-2 block ">Password</label>
                                    <input type="password" name="password" wire:model="password"
                                           class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full">
                                    @error('password')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex-1 mb-3">
                                    <label for="confirm_password" class="text-[10px] font-natural px-2 block ">Confirm
                                        Password</label>
                                    <input type="password" name="confirm_password" wire:model="confirm_password"
                                           class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full">
                                    @error('confirm_password')
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
                            Proceed to Access Role and Permission
                        </button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
