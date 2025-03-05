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
        <div class="bg-transparent py-0 min-h-screen px-6 mt-2">
            <div class="mx-auto ">
                <div class="flex flex-row justify-between items-start mb-4">
                    <div class="mb-2 md:mb-0 text-left">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Vote Tally</h1>
                        <p class=" text-[11px] text-gray-500 capitalize">Showing realtime vote tallying of the University of Southeastern Philippines Elections</p>
                    </div>
                </div>
            </div>
            <livewire:vote-tally.realtime-vote-tally/>
        </div>
    </x-slot>
</x-app-layout>
