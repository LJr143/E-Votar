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
        <div class="mx-auto p-6 w-full">
            <div class="flex flex-row justify-between items-start mb-4">
                <div class="mb-2 md:mb-0 text-left">
                    <h1 class="text-base font-semibold leading-6 text-black">Active Users</h1>
                    <p class="text-[11px] text-gray-500">List of active users</p>
                </div>
            </div>
            <div class="flex space-x-4 w-full">
                <!-- Left Section -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow w-3/4">
                    <div>
                        <livewire:manage-active-user.active-user-table/>
                    </div>
                </div>
               <div class="w-1/4">
                   <livewire:manage-active-user.active-user-card/>
               </div>

            </div>
        </div>
    </x-slot>
</x-app-layout>
