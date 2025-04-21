<style>
    .icon {
        width: 38px;
        margin-right: 10px;
        border-radius: 60px;
    }
</style>

<div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden z-50 lg:hidden" onclick="toggleSidebar()"></div>
<div class="flex items-center justify-between w-full ">

    <div class="flex w-1/2">
        <div>
            <img src="{{ asset('storage/assets/logo/evotar_red.png') }}" alt="evotar-logo" class="w-[190px]">
        </div>
        <div class="flex px-6 ml-10 w-1/2 ">
            <img class="icon" src="{{ asset('storage/assets/logo/usep_logo.jpg') }}" alt="usep_logo">
            <img class="icon" src="{{ asset('storage/assets/logo/usg_logo.png') }}" alt="usg_logo">
            <img class="icon" src="{{ asset('storage/assets/logo/tsc_logo.png') }}" alt="tsc_logo">
            <img class="icon" src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}" alt="tsc_comelec_logo">
        </div>

    </div>
    <div class="flex w-1/2 justify-end">
        <div class="flex justify-end relative w-1/2 space-x-4 mr-4">
            <div class="ml-2">
                <h3 class="text-gray-900 text-[14px] text-center tracking-tight capitalize font-light italic"> Hi! {{auth()->user()->first_name}} {{auth()->user()->middle_initial}}
                    . {{auth()->user()->last_name}}</h3>
                <p class="text-gray-500 text-[10px] capitalize">
                    @php
                        // Convert program names
                        $program = auth()->user()->program->name;
                        if (str_starts_with($program, 'Bachelor of Science')) {
                            $program = 'BS ' . substr($program, strlen('Bachelor of Science '));
                        } elseif (str_starts_with($program, 'Bachelor of Education')) {
                            $program = 'BE ' . substr($program, strlen('Bachelor of Education '));
                        } elseif (str_starts_with($program, 'Bachelor of Technical-Vocation')) {
                            $program = 'BTV ' . substr($program, strlen('Bachelor of Technical-Vocation'));
                        }
                        echo $program;
                    @endphp
                    <span> - {{ auth()->user()->year_level }} year</span>
                </p>
            </div>
            <div class="border-[1px] border-gray-800 rounded-full overflow-hidden w-[33px] h-[33px]">
                <img alt="Profile Picture" class="w-8 h-8 rounded-full" height="32"
                     src="{{ asset('storage/' . (auth()->user()->profile_photo_path ?? 'assets/profile/default.jpg) }}" width="32"/>
            </div>
            <div class="mt-2">
                <x-dropdown align="right" width="58" contentClasses="py-2 bg-white"
                            dropdownClasses="border border-gray-200">
                    <x-slot name="trigger">
                        <button class="mt-2">
                            <svg width="12" height="6" viewBox="0 0 12 6" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.68448 0.155061C0.872433 -0.0328917 1.16655 -0.0499784 1.3738 0.103801L1.43318 0.155061L6.00001 4.72165L10.5668 0.155062C10.7548 -0.0328913 11.0489 -0.0499779 11.2562 0.103802L11.3155 0.155062C11.5035 0.343014 11.5206 0.63713 11.3668 0.844385L11.3155 0.903763L6.37436 5.84494C6.1864 6.03289 5.89229 6.04998 5.68503 5.8962L5.62566 5.84494L0.68448 0.903762C0.477732 0.697014 0.477732 0.361809 0.68448 0.155061Z"
                                    fill="#808080" fill-opacity="0.55"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <ul class="py-1 text-[10px]">
                            <!-- Account Settings -->
                            <a href="{{ route('voter.account.settings') }}">
                                <li class="flex items-center px-5 py-4 hover:bg-gray-200 cursor-pointer">
                                    <svg class="w-4 h-4 mr-2 text-gray-600"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#1F2937" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M18.7273 14.7273C18.6063 15.0015 18.5702 15.3056 18.6236 15.6005C18.6771 15.8954 18.8177 16.1676 19.0273 16.3818L19.0818 16.4364C19.2509 16.6052 19.385 16.8057 19.4765 17.0265C19.568 17.2472 19.6151 17.4838 19.6151 17.7227C19.6151 17.9617 19.568 18.1983 19.4765 18.419C19.385 18.6397 19.2509 18.8402 19.0818 19.0091C18.913 19.1781 18.7124 19.3122 18.4917 19.4037C18.271 19.4952 18.0344 19.5423 17.7955 19.5423C17.5565 19.5423 17.3199 19.4952 17.0992 19.4037C16.8785 19.3122 16.678 19.1781 16.5091 19.0091L16.4545 18.9545C16.2403 18.745 15.9682 18.6044 15.6733 18.5509C15.3784 18.4974 15.0742 18.5335 14.8 18.6545C14.5311 18.7698 14.3018 18.9611 14.1403 19.205C13.9788 19.4489 13.8921 19.7347 13.8909 20.0273V20.1818C13.8909 20.664 13.6994 21.1265 13.3584 21.4675C13.0174 21.8084 12.5549 22 12.0727 22C11.5905 22 11.1281 21.8084 10.7871 21.4675C10.4461 21.1265 10.2545 20.664 10.2545 20.1818V20.1C10.2475 19.7991 10.1501 19.5073 9.97501 19.2625C9.79991 19.0176 9.55521 18.8312 9.27273 18.7273C8.99853 18.6063 8.69437 18.5702 8.39947 18.6236C8.10456 18.6771 7.83244 18.8177 7.61818 19.0273L7.56364 19.0818C7.39478 19.2509 7.19425 19.385 6.97353 19.4765C6.7528 19.568 6.51621 19.6151 6.27727 19.6151C6.03834 19.6151 5.80174 19.568 5.58102 19.4765C5.36029 19.385 5.15977 19.2509 4.99091 19.0818C4.82186 18.913 4.68775 18.7124 4.59626 18.4917C4.50476 18.271 4.45766 18.0344 4.45766 17.7955C4.45766 17.5565 4.50476 17.3199 4.59626 17.0992C4.68775 16.8785 4.82186 16.678 4.99091 16.5091L5.04545 16.4545C5.25503 16.2403 5.39562 15.9682 5.4491 15.6733C5.50257 15.3784 5.46647 15.0742 5.34545 14.8C5.23022 14.5311 5.03887 14.3018 4.79497 14.1403C4.55107 13.9788 4.26526 13.8921 3.97273 13.8909H3.81818C3.33597 13.8909 2.87351 13.6994 2.53253 13.3584C2.19156 13.0174 2 12.5549 2 12.0727C2 11.5905 2.19156 11.1281 2.53253 10.7871C2.87351 10.4461 3.33597 10.2545 3.81818 10.2545H3.9C4.2009 10.2475 4.49273 10.1501 4.73754 9.97501C4.98236 9.79991 5.16883 9.55521 5.27273 9.27273C5.39374 8.99853 5.42984 8.69437 5.37637 8.39947C5.3229 8.10456 5.18231 7.83244 4.97273 7.61818L4.91818 7.56364C4.74913 7.39478 4.61503 7.19425 4.52353 6.97353C4.43203 6.7528 4.38493 6.51621 4.38493 6.27727C4.38493 6.03834 4.43203 5.80174 4.52353 5.58102C4.61503 5.36029 4.74913 5.15977 4.91818 4.99091C5.08704 4.82186 5.28757 4.68775 5.50829 4.59626C5.72901 4.50476 5.96561 4.45766 6.20455 4.45766C6.44348 4.45766 6.68008 4.50476 6.9008 4.59626C7.12152 4.68775 7.32205 4.82186 7.49091 4.99091L7.54545 5.04545C7.75971 5.25503 8.03183 5.39562 8.32674 5.4491C8.62164 5.50257 8.9258 5.46647 9.2 5.34545H9.27273C9.54161 5.23022 9.77093 5.03887 9.93245 4.79497C10.094 4.55107 10.1807 4.26526 10.1818 3.97273V3.81818C10.1818 3.33597 10.3734 2.87351 10.7144 2.53253C11.0553 2.19156 11.5178 2 12 2C12.4822 2 12.9447 2.19156 13.2856 2.53253C13.6266 2.87351 13.8182 3.33597 13.8182 3.81818V3.9C13.8193 4.19253 13.906 4.47834 14.0676 4.72224C14.2291 4.96614 14.4584 5.15749 14.7273 5.27273C15.0015 5.39374 15.3056 5.42984 15.6005 5.37637C15.8954 5.3229 16.1676 5.18231 16.3818 4.97273L16.4364 4.91818C16.6052 4.74913 16.8057 4.61503 17.0265 4.52353C17.2472 4.43203 17.4838 4.38493 17.7227 4.38493C17.9617 4.38493 18.1983 4.43203 18.419 4.52353C18.6397 4.61503 18.8402 4.74913 19.0091 4.91818C19.1781 5.08704 19.3122 5.28757 19.4037 5.50829C19.4952 5.72901 19.5423 5.96561 19.5423 6.20455C19.5423 6.44348 19.4952 6.68008 19.4037 6.9008C19.3122 7.12152 19.1781 7.32205 19.0091 7.49091L18.9545 7.54545C18.745 7.75971 18.6044 8.03183 18.5509 8.32674C18.4974 8.62164 18.5335 8.9258 18.6545 9.2V9.27273C18.7698 9.54161 18.9611 9.77093 19.205 9.93245C19.4489 10.094 19.7347 10.1807 20.0273 10.1818H20.1818C20.664 10.1818 21.1265 10.3734 21.4675 10.7144C21.8084 11.0553 22 11.5178 22 12C22 12.4822 21.8084 12.9447 21.4675 13.2856C21.1265 13.6266 20.664 13.8182 20.1818 13.8182H20.1C19.8075 13.8193 19.5217 13.906 19.2778 14.0676C19.0339 14.2291 18.8425 14.4584 18.7273 14.7273Z" stroke="#1F2937" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Account Settings
                                    <svg class="w-3 h-3 ml-5  text-gray-600" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 13L7 7L1 1" stroke="#6B7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </li>
                            </a>
                            <!-- Logout -->
                            <li class="flex items-center px-5 py-3 hover:bg-gray-200 cursor-pointer">
                                <svg  class="w-4 h-4 mr-2 text-gray-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 8L22 12M22 12L18 16M22 12H9M15 4.20404C13.7252 3.43827 12.2452 3 10.6667 3C5.8802 3 2 7.02944 2 12C2 16.9706 5.8802 21 10.6667 21C12.2452 21 13.7252 20.5617 15 19.796" stroke="#1F2937" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <a href="{{ route('logout') }}"
                                   class="text-gray-600 "
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </x-slot>
                </x-dropdown>

            </div>
        </div>
    </div>
</div>


<!-- Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full relative mx-4 sm:mx-0">

        <div class="flex flex-col items-center">
            <div class="text-red-500 text-4xl mb-4">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h2 class="text-[12px] sm:text-sm font-bold text-gray-800 mb-2">Logout</h2>
            <p class="text-[10px] sm:text-[12px] font-regular text-gray-600 text-center mb-6">Are you sure you want to
                log out? You will lose any unsaved changes.</p>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full">
                <button id="cancel-logout"
                        class="bg-white text-gray-700 text-xs sm:text-sm font-regular px-4 py-2 rounded-md w-full lg:w-1/2 border border-gray-300 hover:bg-gray-100">
                    Cancel
                </button>
                <button id="confirm-logout"
                        class="bg-red-500 text-white text-xs sm:text-sm font-bold px-4 py-2 rounded-md w-full lg:w-1/2 hover:bg-red-600">
                    Logout
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
    }

    document.getElementById('cancel-logout').onclick = function () {
        document.getElementById('logoutModal').classList.add('hidden');
    };

    document.getElementById('confirm-logout').onclick = function () {
        document.getElementById('logout-form').submit();
    };

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
        }
    }

    let lastClicked = null;

    function changeColor(element) {
        const links = document.querySelectorAll('#sidebar a');
        links.forEach(link => {
            link.classList.remove('text-green-500');
            link.classList.add('text-black');
            link.querySelector('svg path').setAttribute('stroke', '#000000');
        });

        element.classList.add('text-green-500');
        element.classList.remove('text-black');
        element.querySelector('svg path').setAttribute('stroke', '#00FF00');
    }

</script>
