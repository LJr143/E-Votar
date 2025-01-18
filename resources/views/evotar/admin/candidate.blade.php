<x-app-layout mainClass="flex" page_title="- Candidates">
    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <x-header></x-header>
    </x-slot>
    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 min-h-screen ">
            <div class="mx-auto flex w-full">
                <!-- Left Section -->
                <div class="flex flex-col w-1/3 ">
                    <!-- Header Section -->
                    <div class="flex flex-row justify-between items-start mb-4">
                        <div class="text-left">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Candidates</h1>
                            <p class="text-[11px] text-gray-500">List of candidates of Student and Local Council</p>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex flex-row justify-end w-2/3">
                    <div class="bg-white flex px-4 py-2 items-center w-[190px] justify-center rounded space-x-2">
                        <div class="rounded bg-gray-200 p-[5px]">
                            <svg width="18" height="17" viewBox="0 0 27 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.88381 27.7497H22.4503C23.615 27.7497 24.7321 27.3019 25.5556 26.5049C26.3792 25.7079 26.8419 24.6268 26.8419 23.4997V6.49968C26.8419 5.37251 26.3792 4.2915 25.5556 3.49447C24.7321 2.69744 23.615 2.24967 22.4503 2.24967H20.9864C20.9864 1.87395 20.8322 1.51362 20.5577 1.24794C20.2831 0.982263 19.9108 0.833008 19.5225 0.833008C19.1343 0.833008 18.762 0.982263 18.4874 1.24794C18.2129 1.51362 18.0587 1.87395 18.0587 2.24967H9.27543C9.27543 1.87395 9.1212 1.51362 8.84667 1.24794C8.57214 0.982263 8.1998 0.833008 7.81156 0.833008C7.42331 0.833008 7.05097 0.982263 6.77644 1.24794C6.50191 1.51362 6.34768 1.87395 6.34768 2.24967H4.88381C3.71908 2.24967 2.60205 2.69744 1.77846 3.49447C0.954875 4.2915 0.492188 5.37251 0.492188 6.49968V23.4997C0.492188 24.6268 0.954875 25.7079 1.77846 26.5049C2.60205 27.3019 3.71908 27.7497 4.88381 27.7497ZM3.41994 6.49968C3.41994 6.12395 3.57416 5.76362 3.84869 5.49794C4.12322 5.23226 4.49557 5.08301 4.88381 5.08301H6.34768V6.49968C6.34768 6.8754 6.50191 7.23573 6.77644 7.50141C7.05097 7.76709 7.42331 7.91634 7.81156 7.91634C8.1998 7.91634 8.57214 7.76709 8.84667 7.50141C9.1212 7.23573 9.27543 6.8754 9.27543 6.49968V5.08301H18.0587V6.49968C18.0587 6.8754 18.2129 7.23573 18.4874 7.50141C18.762 7.76709 19.1343 7.91634 19.5225 7.91634C19.9108 7.91634 20.2831 7.76709 20.5577 7.50141C20.8322 7.23573 20.9864 6.8754 20.9864 6.49968V5.08301H22.4503C22.8385 5.08301 23.2109 5.23226 23.4854 5.49794C23.7599 5.76362 23.9142 6.12395 23.9142 6.49968V10.7497H3.41994V6.49968ZM3.41994 13.583H23.9142V23.4997C23.9142 23.8754 23.7599 24.2357 23.4854 24.5014C23.2109 24.7671 22.8385 24.9163 22.4503 24.9163H4.88381C4.49557 24.9163 4.12322 24.7671 3.84869 24.5014C3.57416 24.2357 3.41994 23.8754 3.41994 23.4997V13.583Z" fill="black"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[12px]">Election Title</p>
                            <p class="text-[10px]">Year</p>
                        </div>
                        <div>
                            <x-dropdown align="right" width="48" contentClasses="py-2 bg-white" dropdownClasses="border border-gray-200">
                                <x-slot name="trigger">
                                    <button class="">
                                        <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.68448 0.155061C0.872433 -0.0328917 1.16655 -0.0499784 1.3738 0.103801L1.43318 0.155061L6.00001 4.72165L10.5668 0.155062C10.7548 -0.0328913 11.0489 -0.0499779 11.2562 0.103802L11.3155 0.155062C11.5035 0.343014 11.5206 0.63713 11.3668 0.844385L11.3155 0.903763L6.37436 5.84494C6.1864 6.03289 5.89229 6.04998 5.68503 5.8962L5.62566 5.84494L0.68448 0.903762C0.477732 0.697014 0.477732 0.361809 0.68448 0.155061Z" fill="#808080" fill-opacity="0.55" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content" class="relative mt-10">
                                    <a href="" class="block px-4 py-2 text-[11px] text-gray-700 hover:bg-gray-100">Account Settings</a>
                                    <!-- Logout Form -->


                                    <a href="#"
                                       onclick="event.preventDefault(); showLogoutModal();"
                                       class="block px-4 py-2 text-[11px] text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>


                                </x-slot>
                            </x-dropdown>
                        </div>

                    </div>
                </div>
            </div>

           <livewire:manage-candidate.view-candidate/>
        </div>
    </x-slot>
</x-app-layout>
