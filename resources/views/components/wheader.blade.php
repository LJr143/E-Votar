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
            <a href="#" class="text-white text-xs hover:underline">Contact</a>
            <a href="{{ route('comelec-website.user-feedback') }}" class="text-white text-xs hover:underline">User Feedback</a>
            <a href="#" class="text-white text-xs hover:underline">FAQs</a>
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
                <input class="border border-gray-300 rounded-md py-1 px-3 pl-8 w-full" placeholder="Search..." type="text"/>
                <i class="fas fa-search text-gray-600 absolute left-2 top-2"></i>
            </div>

            <a href="{{ route('comelec-website.home') }}"
                   class="text-xs {{ request()->routeIs('comelec-website.home') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                    Home
            </a>

            <a href="#"
               class="text-xs {{ request()->routeIs('') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                About
            </a>
            <a href=""
               class="text-xs {{ request()->routeIs('') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                Announcements
            </a>
            <a href="{{ route('comelec-website.list-of-elections') }}"
               class="text-xs {{ request()->routeIs('comelec-website.list-of-elections') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                Elections
            </a>
            <a href="{{ route('comelec-website.tutorial') }}"
               class="text-xs {{ request()->routeIs('comelec-website.tutorial') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                Tutorial
            </a>
            <a href=""
               class="text-xs {{ request()->routeIs('') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                Policies
            </a>
            <a href=""
               class="text-xs {{ request()->routeIs('') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                Data Privacy
            </a>

            <!-- search bar for big screens -->
            <div class="flex items-center space-x-2 hidden md:flex text-xs">
                <div class="relative">
                    <input class="border border-gray-300 rounded-md py-1 px-3 pl-8 text-xs w-full" placeholder="Search..." type="text"/>
                    <i class="fas fa-search text-gray-600 absolute left-2 top-2"></i>
                </div>
                <div class="w-px h-6 bg-gray-300"></div>
            </div>
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
