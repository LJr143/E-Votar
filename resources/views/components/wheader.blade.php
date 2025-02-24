<header class="flex flex-col md:flex-row items-center justify-between px-6 sm:px-12 py-4 bg-white shadow-md " x-data="{ open: false }">
    <div class="flex flex-col items-start w-full md:w-auto">
        <div class="flex justify-between w-full md:w-auto">
            <div>
                <span class="text-[10px] md:text-xs text-red-600 block">UNIVERSITY OF SOUTHEASTERN PHILIPPINES</span>
                <span class="text-[12px] md:text-sm font-bold text-red-600 block">COMMISSION ON ELECTION</span>
                <span class="text-[10px] md:text-xs text-gray-600 block">IMPARTIALITY, TRANSPARENCY, INTEGRITY</span>
            </div>
            <button @click="open = !open" class="md:hidden text-red-600"><i class="fas fa-bars"></i></button>
        </div>
    </div>
    <nav :class="{'block': open, 'hidden': !open}" class="md:flex flex-wrap items-center space-x-4 mt-4 md:mt-0 flex flex-col md:flex-row space-y-2 md:space-y-0 hidden">

        <!-- search bar for smaller screens -->
        <div class="relative md:hidden w-full mb-2 text-[11px]">
            <input class="border border-gray-300 rounded-md py-1 px-3 pl-8 w-full" placeholder="Search..." type="text"/>
            <i class="fas fa-search text-gray-600 absolute left-2 top-2"></i>
        </div>

        <a class="text-red-600 font-semibold text-sm hover:text-red-800" href="#">Home</a>
        <a class="text-red-600 text-sm hover:text-red-800" href="#">Announcements</a>
        <a class="text-red-600 text-sm hover:text-red-800" href="#">Elections</a>
        <a class="text-red-600 text-sm hover:text-red-800" href="#">Policies</a>
        <a class="text-red-600 text-sm hover:text-red-800" href="#">About</a>
        <a class="text-red-600 text-sm hover:text-red-800" href="#">Contact</a>
        <a class="text-red-600 text-sm hover:text-red-800" href="#">Feedback</a>

        <!-- search bar for big screens -->
        <div class="flex items-center space-x-2 hidden md:flex text-sm">
            <div class="relative">
                <input class="border border-gray-300 rounded-md py-1 px-3 pl-8 w-full" placeholder="Search..." type="text"/>
                <i class="fas fa-search text-gray-600 absolute left-2 top-2"></i>
            </div>
            <div class="w-px h-6 bg-gray-300"></div>
        </div>
        <div class="hidden md:flex space-x-2">
            <img alt="USeP LOGO" class="h-6 w-6 rounded-full hover:opacity-75" src="{{ asset('storage/assets/logo/usep_logo.jpg') }}" />
            <img alt="USG LOGO" class="h-6 w-6 rounded-full hover:opacity-75" src="{{ asset('storage/assets/logo/usg_logo.jpg') }}" />
            <img alt="USG LOGO" class="h-6 w-6 rounded-full hover:opacity-75" src="{{ asset('storage/assets/logo/usg_logo.png') }}" />
            <img alt="COMELEC LOGO" class="h-6 w-6 rounded-full hover:opacity-75" src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}" />
            <img alt="TSC LOGO" class="h-6 w-6 rounded-full hover:opacity-75" src="{{ asset('storage/assets/logo/tsc_logo.png') }}" />

        </div>
    </nav>
</header>
