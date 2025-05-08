<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <main>
            <div class="relative">
                <img alt="Eagle" class="w-full h-full object-cover" src="{{ asset('storage/assets/image/eaglee.png') }}"  />
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-50">
                    <h1 class="text-4xl font-bold text-white">
                        About Us
                    </h1>
                    <nav class="mt-2">
                        <a class="text-white text-xs" href="#">
                            Home
                        </a>
                        <span class="mx-2 text-xs text-white">
                          &gt;
                         </span>
                        <a class="text-white text-xs" href="#">
                            About Us
                        </a>
                    </nav>
                </div>
            </div>
            <div class="py-12">
                <div class="container mx-auto px-10">
                    <h2 class="text-3xl font-bold text-center mb-4 text-black">
                        Who We Are
                    </h2>
                    <p class="text-center text-gray-600 mb-8 text-justify text-sm">
                        The Commission on Elections (COMELEC) - University of Southeastern Philippines is the official student body responsible for organizing and overseeing fair, transparent, and efficient student elections. As an autonomous institution, we uphold democratic principles by ensuring that every student has a voice in electing their leaders.
                    </p>

                    <div class="flex flex-col lg:flex-row justify-center items-start lg:space-x-12">
                        <div class="lg:w-1/3 mb-8 lg:mb-0">
                            <div class="relative w-full max-w-md">
                                <img src="https://placehold.co/400x300" alt="Person holding a book with a plant in the background" class="rounded-lg shadow-lg w-full"/>
                                <button class="absolute inset-0 flex items-center justify-center text-white text-3xl">
                                    <i class="fas fa-play-circle"></i>
                                </button>
                            </div>
                            <div class="bg-white p-4 text-sm rounded-lg shadow-lg mt-4 text-center w-full max-w-md">
                                <p class="font-bold">"Making an impact, together"</p>
                                <p class="text-gray-600">Socialy Founder</p>
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 flex flex-col text-justify justify-center">
                            <h2 class="text-3xl md:text-3xl font-bold mb-4 ">
                                What We Do
                            </h2>
                            <p class="text-gray-600 text-sm mb-4">
                                Conduct Elections: Organizing and managing fair and transparent student government elections.
                                Voter Education: Raising awareness about the importance of voting and guiding students through the election process.
                                Election Security: Implementing secure and efficient voting procedures, including online and traditional methods.
                                Candidate Evaluation: Ensuring that all candidates comply with election guidelines and uphold ethical standards.
                                Transparency & Fairness: Providing real-time updates, result tabulations, and audit trails for election credibility.
                            </p>
                            <p class="text-gray-600 text-sm italic border-l-4 border-yellow-500 pl-4">
                                Unitas in Progrediendo “unity in progress”
                            </p>
                            <h2 class="text-3xl mt-5 md:text-3xl font-bold mb-4 ">
                                Why it Matters?
                            </h2>
                            <p class="text-gray-600 text-sm mb-4">
                                Student elections are the foundation of strong leadership and representation in our institution. Through COMELEC, we ensure that every student's vote counts and contributes to a more democratic and student-centered governance.
                            </p>

                        </div>
                    </div>

                    </div>
                </div>
        </main>



    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>

</x-custom-layout>


