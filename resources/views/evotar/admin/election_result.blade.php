<x-app-layout mainClass="flex" page_title="- Election Result">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-6 py-0 min-h-screen ">
            <div class="mx-auto flex w-full">
                <!-- Left Section -->
                <div class="flex flex-col ">
                    <!-- Header Section -->
                    <div class="flex flex-row justify-between items-start mb-4">
                        <div class="text-left">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Election Result</h1>
                            <p class="text-[11px] text-gray-500">Election results</p>
                        </div>
                    </div>
                </div>
            </div>

            <livewire:election-result.election-result/>
        </div>
    </x-slot>
</x-app-layout>
