<x-app-layout mainClass="flex" page_title="- Voters">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <x-header></x-header>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 min-h-screen ">
            <div class="mx-auto flex w-full">
                <div class="flex flex-col w-1/3 ">
                    <div class="flex flex-row justify-between items-start mb-4">
                        <div class="text-left">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Voters</h1>
                            <p class="text-[11px] text-gray-500">List of USeP E-votar Election Voters</p>
                        </div>
                    </div>
                </div>
            </div>
            <livewire:manage-voter.voter-table/>
        </div>
    </x-slot>
</x-app-layout>

