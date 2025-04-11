<x-app-layout mainClass="flex" headerClass="" page_title="- Database Backup">

    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="mx-auto p-6">
            <div class="flex flex-row justify-between items-start mb-4">
                <div class="mb-2 md:mb-0 text-left">
                    <h1 class="text-base font-semibold leading-6 text-black">Database Backup</h1>
                    <p class="text-[11px] text-gray-500"> Manage and create backups of the database to ensure data safety and recovery.</p>
                </div>
            </div>
                <livewire:manage-database.manage-database-backup/>
            </div>
    </x-slot>
</x-app-layout>
