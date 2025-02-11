<x-app-layout mainClass="flex" headerClass="" page_title="- Dashboard">

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-evotar-components::voter.voter-header></x-evotar-components::voter.voter-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <livewire:voter.voting-process :slug="$slug"/>
    </x-slot>
</x-app-layout>
