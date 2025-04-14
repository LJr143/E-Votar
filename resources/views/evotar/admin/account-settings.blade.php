<x-app-layout mainClass="flex" headerClass="" page_title="- Account Settings">

    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-header></x-header>
        </div>
    </x-slot>
    <x-slot name="main" class="px-6 mt-2">
        <style>
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e0;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #a0aec0;
            }

            /* Soft shadows */
            .soft-shadow {
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            }

            /* Horizontal tabs scroll */
            .horizontal-tabs {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none; /* Firefox */
            }

            .horizontal-tabs::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Edge */
            }

            /* Responsive adjustments */
            @media (max-width: 640px) {
                .container-custom {
                    width: 95%;
                    padding: 0.5rem;
                }
            }

            @media (min-width: 641px) and (max-width: 768px) {
                .container-custom {
                    width: 90%;
                    padding: 0.5rem;
                }
            }

            @media (min-width: 769px) {
                .container-custom {
                    width: 100%;
                    padding: 0.5rem;
                }
            }
        </style>
        <livewire:account-settings.admin-account-settings/>
    </x-slot>
</x-app-layout>



