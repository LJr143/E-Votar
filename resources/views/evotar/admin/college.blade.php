<x-app-layout mainClass="flex" page_title="- Manage College">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main" class="px-6 mt-2">
        <div class="bg-transparent py-0 min-h-screen px-6 mt-2">
            <div class="mx-auto ">
                <div class="flex flex-row justify-between items-start mb-4">
                    <div class="mb-2 md:mb-0 text-left">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Manage Colleges</h1>
                        <p class=" text-[11px] text-gray-500">List of Colleges of University of Southeastern Philippines</p>
                    </div>
                </div>
            </div>
            <livewire:manage-college.manage-college-table/>
        </div>

    </x-slot>
</x-app-layout>
