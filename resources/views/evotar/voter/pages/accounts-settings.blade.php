<x-app-layout mainClass="flex" page_title="- voter account settings">
    <x-slot name="main">

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
                    width: 85%;
                    max-width: 1200px;
                    padding: 0.5rem;
                }
            }
        </style>

        <div x-data="accountSettings()" class="min-h-screen p-2 sm:p-3 md:p-6 bg-white">
            <div class="container-custom mx-auto">
                <!-- Header with Back Button -->
                <div class="flex items-center gap-2 sm:gap-3 mb-1">
                    <button
                        @click="goBack()"
                        class="flex items-center justify-center h-8 w-8 rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors soft-shadow"
                        aria-label="Go back"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><path d="M12 19l-7-7 7-7"></path></svg>
                    </button>
                    <h1 class="text-base sm:text-xl font-semibold text-gray-700">Account Settings</h1>
                </div>

                <p class="text-xs text-gray-500 mb-3">Manage your personal information, security, and system preferences</p>

                <livewire:account-settings.admin-account-settings/>
            </div>
        </div>



        <script>
            function accountSettings() {
                return {
                    goBack() {
                        if (document.referrer) {
                            window.history.back();
                        } else {
                            window.location.href = '/';
                        }
                    }

                }
            }
        </script>

    </x-slot>
</x-app-layout>
