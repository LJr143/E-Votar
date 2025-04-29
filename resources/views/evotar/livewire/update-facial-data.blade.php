<div x-data="{ open: false }" x-cloak @update-user-face-datae.window="open = false">
    <!-- Trigger Button -->
    <button type="button" @click="open = true"
            class="border border-yellow-500 text-yellow-500 px-6 py-1 h-7 rounded shadow-md hover:bg-yellow-100 text-[12px] justify-center text-center mb-6 md:mb-0 hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
        Update User Facial Biometrics
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
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                    <h2 class="text-sm font-semibold text-yellow-600">Verify User</h2>
                </div>
                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-gray-700 mb-6 ml-5 text-xs text-left">Are you sure you want to update facial biometrics for this user? This
                process cannot be undone <span class="font-semibold italic">{{ ($user->first_name ?? '') . ' ' .
               ($user->middle_initial ? $user->middle_initial . '. ' : '') .
               ($user->last_name ?? '') .
               ($user->extension ? ' ' . $user->extension : '') }}</span>.</p>

            <form wire:submit.prevent="updateUserFaceData">
                <div>
                    <x-input
                        type="password"
                        wire:model.defer="password"
                        class="border border-gray-300 rounded w-full p-2 text-sm"
                        placeholder="Enter your password"
                    />
                    @error('password') <span class="text-yellow-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end mt-4 space-x-2">
                    <button @click="open = false" type="button" class="px-4 py-2 border rounded-md text-xs">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md text-xs">
                        Proceed to Facial Registration
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>
