<div x-data="{ open: false }" x-cloak @system-user-deleted.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true"
            class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
        <svg width="15" height="17" viewBox="0 0 15 17" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M2.8077 16.9998C2.31058 16.9998 1.88502 16.8228 1.53102 16.4688C1.17701 16.1148 1 15.6892 1 15.1921V2.49981H0.75C0.5375 2.49981 0.359375 2.4279 0.215625 2.28408C0.071875 2.14028 0 1.96208 0 1.74948C0 1.5369 0.071875 1.35882 0.215625 1.21523C0.359375 1.07163 0.5375 0.999834 0.75 0.999834H4.49997C4.49997 0.754967 4.58619 0.546318 4.75863 0.373885C4.93106 0.201451 5.13971 0.115234 5.38457 0.115234H9.61538C9.86024 0.115234 10.0689 0.201451 10.2413 0.373885C10.4138 0.546318 10.5 0.754967 10.5 0.999834H14.25C14.4625 0.999834 14.6406 1.07174 14.7843 1.21556C14.9281 1.35938 15 1.53758 15 1.75016C15 1.96276 14.9281 2.14085 14.7843 2.28443C14.6406 2.42802 14.4625 2.49981 14.25 2.49981H14V15.1921C14 15.6892 13.8229 16.1148 13.4689 16.4688C13.1149 16.8228 12.6894 16.9998 12.1922 16.9998H2.8077ZM12.5 2.49981H2.49997V15.1921C2.49997 15.2818 2.52883 15.3556 2.58652 15.4133C2.64422 15.471 2.71795 15.4998 2.8077 15.4998H12.1922C12.282 15.4998 12.3557 15.471 12.4134 15.4133C12.4711 15.3556 12.5 15.2818 12.5 15.1921V2.49981ZM5.65417 13.4998C5.86676 13.4998 6.04484 13.4279 6.18842 13.2842C6.33202 13.1404 6.40382 12.9623 6.40382 12.7498V5.24979C6.40382 5.0373 6.33192 4.85918 6.1881 4.71543C6.04428 4.57168 5.86608 4.49981 5.6535 4.49981C5.4409 4.49981 5.26281 4.57168 5.11922 4.71543C4.97564 4.85918 4.90385 5.0373 4.90385 5.24979V12.7498C4.90385 12.9623 4.97576 13.1404 5.11958 13.2842C5.26337 13.4279 5.44158 13.4998 5.65417 13.4998ZM9.34645 13.4998C9.55905 13.4998 9.73714 13.4279 9.88072 13.2842C10.0243 13.1404 10.0961 12.9623 10.0961 12.7498V5.24979C10.0961 5.0373 10.0242 4.85918 9.88037 4.71543C9.73658 4.57168 9.55837 4.49981 9.34577 4.49981C9.13319 4.49981 8.95511 4.57168 8.81152 4.71543C8.66792 4.85918 8.59613 5.0373 8.59613 5.24979V12.7498C8.59613 12.9623 8.66803 13.1404 8.81185 13.2842C8.95567 13.4279 9.13387 13.4998 9.34645 13.4998Z"
                fill="#35353A"/>
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
            class="bg-white p-6 rounded shadow-md max-w-md w-full mx-4 sm:mx-6 md:mx-8 lg:mx-10 xl:mx-12"
        >

            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <h2 class="text-sm font-semibold text-red-600">Delete User</h2>
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
            <p class="text-gray-700 mb-4 ml-5 text-[10px] sm:text-[12px] text-left">
                Are you sure you want to remove this user? This process <br>
                cannot be undone {{ $user->first_name }}.
            </p>

            <form wire:submit.prevent="deleteUser">
                <div>
                    <x-input
                        type="password"
                        wire:model.defer="password"
                        class="border border-gray-300 rounded w-full p-2 text-sm"
                        placeholder="Enter your password"
                    />
                    @error('password') <div class="text-red-500 text-[10px] sm:text-[12px]">{{ $message }}</div> @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end mt-4 space-x-2">
                    <button @click="open = false" type="button" class="px-4 py-2 border rounded-md text-xs hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md text-xs hover:drop-shadow  hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                        Delete
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>
