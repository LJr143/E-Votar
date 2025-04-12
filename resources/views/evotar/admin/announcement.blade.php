<x-app-layout mainClass="flex" page_title="- Announcement">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 min-h-screen">
            <div class="container mx-auto p-4" x-data="announcementApp()">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Announcement</h1>
                    <p class="text-[11px] text-gray-700" x-text="currentDate"></p>
                </div>


               <div>
                   <livewire:announcement.create-announcement/>
               </div>

                <div>
                    <livewire:announcement.announcement-list/>
                </div>

            </div>

{{--            <!-- Livewire component - Make sure it's visible in the DOM -->--}}
{{--            <div>--}}
{{--                <livewire:manage-announcements.edit-announcement />--}}
{{--            </div>--}}

        </div>
    </x-slot>
</x-app-layout>

