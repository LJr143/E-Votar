<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader />
    </x-slot>

    <x-slot name="main">


        <main>
            <livewire:announcement.selected-announcement :announcement="$announcement"/>
        </main>

    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter />
    </x-slot>

</x-custom-layout>


