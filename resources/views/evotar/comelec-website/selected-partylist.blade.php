<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader />
    </x-slot>

    <x-slot name="main">
        <main>


        <livewire:partylist-members :partylistId="$partyList->id"/>



        </main>

    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter />
    </x-slot>

</x-custom-layout>


