<x-app-layout mainClass="flex" headerClass="" page_title="- Dashboard">

    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
      <div class="px-6 w-full">
          <x-header></x-header>
      </div>
    </x-slot>
    <x-slot name="main" class="px-6 mt-2">

        <livewire:dashboard.watcher-dashboard/>
    </x-slot>
</x-app-layout>



