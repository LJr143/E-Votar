<header>
    <div class="flex flex-col md:flex-row justify-between items-center bg-black py-1- px-6 sm:px-12">
        <div class="flex space-x-4 mb-2 md:mb-0">
            <a href="https://www.facebook.com" target="_blank">
                <i class="fab fa-facebook text-white text-sm"></i>
            </a>
            <a href="https://www.youtube.com" target="_blank">
                <i class="fab fa-youtube text-white text-sm"></i>
            </a>
            <a href="https://www.instagram.com" target="_blank">
                <i class="fab fa-instagram text-white text-sm"></i>
            </a>
            <a href="tel:+1234567890">
                <i class="fas fa-phone text-white text-sm"></i>
            </a>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('comelec-website.contact-us') }}" class="text-white text-xs hover:underline">Contact Us</a>
            @if(Auth::check()) <!-- Check if the user is logged in -->
            <a href="{{ route('comelec-website.user-feedback') }}" class="text-white text-xs hover:underline">User  Feedback</a>
            @else
                <a href="{{ route('comelec-website.website-login') }}" class="text-white text-xs hover:underline">Login to Provide Feedback</a>
            @endif

            <a href="{{ route('comelec-website.faqs') }}" class="text-white text-xs hover:underline">FAQs</a>
        </div>
    </div>
    <div class="flex flex-col md:flex-row items-center justify-between px-6 sm:px-12 py-4 bg-white shadow-md" x-data="{ open: false }">
        <div class="flex flex-col items-start w-full md:w-auto">
            <div class="flex justify-between w-full md:w-auto">
                <div>
                    <span class="text-[10px] md:text-[10px] text-black block">UNIVERSITY OF SOUTHEASTERN PHILIPPINES</span>
                    <span class="text-[12px] md:text-[14px] font-bold text-black block">COMMISSION ON ELECTION</span>
                    <span class="text-[10px] md:text-[10px] text-gray-600 block">IMPARTIALITY, TRANSPARENCY, INTEGRITY</span>
                </div>
                <button @click="open = !open" class="md:hidden text-red-600">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <nav :class="{'block': open, 'hidden': !open}" class="md:flex flex-wrap items-center space-x-4 mt-4 md:mt-0 flex flex-col md:flex-row space-y-2 md:space-y-0 hidden">
            <!-- search bar for smaller screens -->
            <div class="relative md:hidden w-full mb-2 text-[11px]">
                <input class="border border-gray-300 rounded-md py-2 px-3 pl-8 text-xs w-full focus:border-black focus:ring-black outline-none"
                       placeholder="Search..." type="text"/>
                <svg class="absolute left-2 top-2" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                </svg>
            </div>


            <a href="{{ route('comelec-website.home') }}"
                   class="text-xs {{ request()->routeIs('comelec-website.home') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                    Home
            </a>
            <a href="{{ route('comelec-website.about-us') }}"
               class="text-xs {{ request()->routeIs('comelec-website.about-us') ? 'font-semibold' : 'text-black hover:text-gray-500' }}">
                About
            </a>
            <a href="{{ route('comelec-website.list-of-elections') }}"
               class="text-xs {{ request()->routeIs('comelec-website.list-of-elections') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                Elections
            </a>
            <a href="{{ route('comelec-website.tutorial') }}"
               class="text-xs {{ request()->routeIs('comelec-website.tutorial') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                Tutorial
            </a>
            <a href="{{ route('comelec-website.policies') }}"
               class="text-xs {{ request()->routeIs('comelec-website.policies') ? 'font-semibold' : 'text-black hover:text-gray-500' }}">
                Policies
            </a>
            <a href="{{ route('comelec-website.data-privacy') }}"
               class="text-xs {{ request()->routeIs('comelec-website.data-privacy') ? 'font-semibold' : 'text-black hover:text-gray-500' }}">
                Data Privacy
            </a>


            <!-- search bar for big screens -->
            <div x-data="{ expanded: false, search: '' }" class="relative">
                <div class="hidden md:flex text-xs items-center rounded overflow-hidden transition-all duration-300"
                     :class="expanded ? 'w-64 bg-white border border-gray-300' : 'w-10 bg-transparent'">
                    <button @click="expanded = !expanded" class="p-3 text-gray-500 focus:outline-none">
                        <svg width="15" height="15" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z" fill="#000000"/>
                        </svg>
                    </button>
                    <input type="text" placeholder="Search..." x-model="search"
                           @focus="expanded = true" @blur="if (!search) expanded = false"
                           class="flex-grow px-2 py-3 text-xs text-gray-700 transition-all duration-300 outline-none border-none"
                           x-show="expanded" x-cloak>
                </div>
            </div>

            <div class="w-px h-6 bg-gray-300"></div>

            <div class="hidden md:flex space-x-2">
                <img alt="USeP LOGO" class="h-6 w-6 rounded-full hover:opacity-75" height="24" src="{{ asset('storage/assets/logo/usep_logo.jpg') }}" width="24"/>
                <img alt="USG LOGO" class="h-6 w-6 rounded-full hover:opacity-75" height="24" src="{{ asset('storage/assets/logo/usg_logo.jpg') }}" width="24"/>
                <img alt="USG LOGO" class="h-6 w-6 rounded-full hover:opacity-75" height="24" src="{{ asset('storage/assets/logo/usg_logo.png') }}" width="24"/>
                <img alt="COMELEC LOGO" class="h-6 w-6 rounded-full hover:opacity-75" height="24" src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}" width="24"/>
                <img alt="TSC LOGO" class="h-6 w-6 rounded-full hover:opacity-75" height="24" src="{{ asset('storage/assets/logo/tsc_logo.png') }}" width="24"/>
            </div>
        </nav>
    </div>
</header>
