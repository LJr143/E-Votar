<header>
    <div class="flex flex-col md:flex-row justify-between items-center bg-black py-1- px-6 sm:px-12">
        <div class="flex space-x-4 mb-2 md:mb-0">
            <a href="https://www.facebook.com/TSCComElec.USeP" target="_blank">
                <i class="fab fa-facebook text-white text-sm"></i>
            </a>
            <a href="mailto:tsccomelec@usep.edu.ph">
                <i class="fas fa-envelope text-white text-sm"></i>
            </a>

        </div>
        <div class="flex space-x-4">
            <a href="{{ route('comelec-website.contact-us') }}" class="text-white text-xs hover:underline">Contact Us</a>
            <a href="{{ route('comelec-website.user-feedback') }}" class="text-white text-xs hover:underline">User  Feedback</a>
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


            <a href="{{ route('comelec-website.home') }}"
                   class="text-xs {{ request()->routeIs('comelec-website.home') ? ' font-semibold' : 'text-black hover:text-gray-500' }}">
                    Home
            </a>
            <a href="{{ route('comelec-website.about-us') }}"
               class="text-xs {{ request()->routeIs('comelec-website.about-us') ? 'font-semibold' : 'text-black hover:text-gray-500' }}">
                About
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
