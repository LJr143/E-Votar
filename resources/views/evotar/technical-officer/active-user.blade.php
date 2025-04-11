<x-app-layout mainClass="flex" headerClass="" page_title="- Active Users">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main" class="px-6 mt-2">
        <div class="mx-auto p-6 w-full" x-data="{ showUserModal: false }">
            <div class="flex flex-row justify-between items-start mb-4">
                <div class="mb-2 md:mb-0 text-left">
                    <h1 class="text-base font-semibold leading-6 text-black">Active Users</h1>
                    <p class="text-[11px] text-gray-500">List of active users</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-4 w-full">
                <!-- Left Section -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow w-full md:w-3/4">
                    <div>
                        <livewire:manage-active-user.active-user-table/>
                    </div>
                </div>

                <!-- Right Section - Visible on md screens and up -->
                <div class="hidden lg:block md:w-1/4">
                    <livewire:manage-active-user.active-user-card/>
                </div>

                <!-- Modal for mobile - Shown when a user is selected -->
                <div
                    x-show="showUserModal"
                    x-on:user-selected.window="showUserModal = true"
                    x-on:click.away="showUserModal = false"
                    class="fixed inset-0 z-50 overflow-y-auto lg:hidden"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak
                >
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        >
                            <div class="absolute top-0 right-0 pt-4 pr-4">
                                <button
                                    type="button"
                                    class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none"
                                    x-on:click="showUserModal = false"
                                >
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6">
                                <livewire:manage-active-user.active-user-card/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
