<x-app-layout mainClass="" page_title="- Dashboard">
    <style>
        .main {
            padding: 0;
        !important;
        }
    </style>

    <x-slot name="main" class="main">

        <livewire:voter.voter-dashboard :slug="$election_id"/>

    </x-slot>
</x-app-layout>
