<x-app-layout mainClass="flex" headerClass="" page_title="- Dashboard">

    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <x-header></x-header>
    </x-slot>
    <x-slot name="main">
        <div class="mx-auto p-6">
            <div class="flex flex-row justify-between items-start mb-4">
                <div class="mb-2 md:mb-0 text-left">
                    <h1 class="text-base font-semibold leading-6 text-black">IP Records</h1>
                    <p class="text-[11px] text-gray-500">List of IP records</p>
                </div>
            </div>

        </div>
    </x-slot>
</x-app-layout>
