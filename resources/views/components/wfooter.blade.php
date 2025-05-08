
<footer class="mx-auto px-8 py-8 bg-black text-white">
    <a href="{{ route('voter.login') }}" class="fixed z-[9999] right-4 bottom-4 bg-black text-white text-[12px] px-4 py-2 rounded-full shadow-lg hover:bg-gray-700 transition duration-300 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
        </svg>
        Go to USeP E-votar System
    </a>
    <div class="flex flex-col sm:flex-row justify-between items-start">
        <div class="flex flex-col items-start px-4 lg:px-20">
            <div class="flex items-center mb-4 w-full sm:w-96">
                <img alt="COMOLEC LOGO" class="mr-4" height="50" src="{{ asset('storage/assets/logo/tsc_comelec_logo.png') }}" width="50"/>
                <div>
                    <h1 class="text-[11px] font-bold">
                        UNIVERSITY OF SOUTHEASTERN PHILIPPINES
                    </h1>
                    <h2 class="text-[20px] font-bold">
                        COMMISSION ON ELECTION
                    </h2>
                    <p class="text-[11px]">
                        Impartiality. Transparency. Integrity.
                    </p>
                </div>
            </div>
            <div class="flex space-x-2 sm:space-x-4 ml-16">
                <img alt="USeP LOGO" class="w-8 h-8 rounded-full" src="{{ asset('storage/assets/logo/usep_logo.jpg') }}" />
                <img alt="USG LOGO" class="w-8 h-8 rounded-full" src="{{ asset('storage/assets/logo/usg_logo.jpg') }}" />
                <img alt="USG LOGO" class="w-8 h-8 rounded-full" src="{{ asset('storage/assets/logo/usg_logo.png') }}" />
                <img alt="TSC LOGO" class="w-8 h-8 rounded-full" src="{{ asset('storage/assets/logo/tsc_logo.png') }}" />
            </div>
        </div>

        <div class="flex justify-start w-full xl:px-20 mt-4 md:mt-0">
            <div class="flex space-x-10 xl:space-x-20">
                <div>
                    <h3 class="text-[14px] font-bold mb-2">
                        Quick Links
                    </h3>
                    <ul>
                        <li class="mb-1">
                            <a class="hover:underline text-[12px]" href="{{ route('comelec-website.home') }}">
                                Home
                            </a>
                        </li>
                        <li class="mb-1">
                            <a class="hover:underline text-[12px]" href="{{ route('comelec-website.about-us') }}">
                                About
                            </a>
                        </li>
                        <li class="mb-1">
                            <a class="hover:underline text-[12px]" href="{{ route('comelec-website.contact-us') }}">
                                Contact Us
                            </a>
                        </li>
                        <li class="mb-1">
                            <a class="hover:underline text-[12px]" href="{{ route('comelec-website.user-feedback') }}">
                                User Feedback
                            </a>
                        </li>
                        <li class="mb-1">
                            <a class="hover:underline text-[12px]" href="{{ route('comelec-website.faqs') }}">
                                FAQs
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-[14px] font-bold mb-2">
                        Pages
                    </h3>
                    <ul>
                        <li class="mb-1">
                            <a class="hover:underline text-[12px]" href="{{ route('comelec-website.tutorial') }}">
                                Tutorial
                            </a>
                        </li>
                        <li class="mb-1">
                            <a class="hover:underline text-[12px]" href="{{ route('comelec-website.policies') }}">
                                Policies
                            </a>
                        </li>
                        <li class="mb-1">
                            <a class="hover:underline text-[12px]" href="{{ route('comelec-website.data-privacy') }}">
                                Data Privacy
                            </a>
                        </li>
                    </ul>
                </div>


            </div>
        </div>
    </div>
</footer>
