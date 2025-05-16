<x-app-layout mainClass="flex" headerClass="" page_title="- Dashboard">

    <x-slot name="header">
        @if (!session('Admin-Voting-Access'))
        <div class="px-6 w-full">
            <x-evotar-components::voter.voter-header></x-evotar-components::voter.voter-header>
        </div>
        @endif
    </x-slot>
    <x-slot name="main">
      <div class="h-full">
            <livewire:voter.voting-process :slug="$slug"/>
        </div>

    </x-slot>
</x-app-layout>
