<div x-data="{ open: false }" x-cloak @system-user-blocked.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
        class="flex items-center text-[12px] bg-black text-white px-4 py-2 rounded-md mb-4 hover:bg-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF">
            <path d="M768-90 666-192H192v-92q0-25.78 12.5-47.39T239-366q43-26 91-42t99-21L90-768l51-51 678 678-51 51ZM264-264h330l-95-96h-19q-54 0-106 14t-99 42q-4.95 2.94-7.98 8.24Q264-290.47 264-284v20Z"/>
        </svg>
        Block user
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
            class="bg-white p-6 rounded shadow-md max-w-md w-full mx-4 sm:mx-6 md:mx-8 lg:mx-10 xl:mx-12"
        >

            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <h2 class="text-sm font-semibold text-red-600">Block User</h2>
                </div>
                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <p class="text-gray-700 mb-6 ml-5 text-xs text-left">Are you sure you want to block this user? {{ $user->first_name }}.</p>

            <form wire:submit.prevent="blockUser">
                <div>
                    <x-input
                        type="password"
                        wire:model.defer="password"
                        class="border border-gray-300 rounded w-full p-2 text-sm"
                        placeholder="Enter your password"
                    />
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end mt-4 space-x-2">
                    <button @click="open = false" type="button" class="px-4 py-2 border rounded-md text-xs">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md text-xs">
                        Block
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>
