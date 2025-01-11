<x-app-layout mainClass="flex" headerClass="" page_title="- Dashboard">

    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <x-header></x-header>
    </x-slot>

    <x-slot name="main">
        <div class="bg-transparent px-2 py-0 ">
            <div class="mx-auto ">
                <div class="flex flex-row justify-between items-start mb-4">
                    <div class="mb-2 md:mb-0 text-left">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Dashboard</h1>
                        <p class=" text-[11px]">Hi, {{ auth()->user()->first_name }}. Welcome back!</p>
                    </div>
                    <div class="relative bg-white p-2 rounded-lg shadow-md flex items-center cursor-pointer space-x-2">
                        <div class="bg-gray-200 p-2 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-gray-600 text-[11px]"></i> <!-- Decreased icon size -->
                        </div>
                        <div>
                            <p class="text-gray-800 text-[10px] font-semibold">Election Title</p>
                            <p class="text-gray-600 text-[9px]">Year</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-600 text-[11px]"></i> <!-- Decreased icon size -->
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 lg:grid-cols-1 w-full gap-4 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4  "> <!-- Reduced gap -->
                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center"> <!-- Reduced padding -->
                        <div class="bg-black flex items-center justify-center rounded-full"
                             style="width: 40px; height: 40px;"> <!-- Set width and height for a perfect circle -->
                            <i class="fas fa-users text-white text-lg"></i> <!-- Icon size -->
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm text-gray-900 font-bold">{{ \App\Models\User::role('voter')->count() }}</h2>
                            <p class="text-[10px] mb-2 font-normal text-gray-500">TOTAL VOTERS</p> <!-- Font size -->
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center"> <!-- Reduced padding -->
                        <div class="bg-black flex items-center justify-center rounded-full"
                             style="width: 40px; height: 40px;"> <!-- Set width and height for a perfect circle -->
                            <i class="fas fa-users text-white text-lg"></i> <!-- Icon size -->
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm text-gray-900 font-bold">0</h2> <!-- Font size -->
                            <p class="text-[10px] mb-2 font-normal text-gray-500">TOTAL CANDIDATES</p>
                            <!-- Font size -->
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center"> <!-- Reduced padding -->
                        <div class="bg-black flex items-center justify-center rounded-full"
                             style="width: 40px; height: 40px;"> <!-- Set width and height for a perfect circle -->
                            <i class="fas fa-users-cog text-white text-lg"></i> <!-- Icon size -->
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm text-gray-900 font-bold">{{ \App\Models\User::has('roles')->count() }}</h2>
                            <p class="text-[10px] mb-2 font-normal text-gray-500">TOTAL SYSTEM USER</p>
                            <!-- Font size -->
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center"> <!-- Reduced padding -->
                        <div class="bg-black flex items-center justify-center rounded-full"
                             style="width: 40px; height: 40px;"> <!-- Set width and height for a perfect circle -->
                            <i class="fas fa-tasks text-white text-lg"></i> <!-- Icon size -->
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm text-gray-900 font-bold">0</h2> <!-- Font size -->
                            <p class="text-[10px] mb-2 font-normal text-gray-500">TOTAL POSITION</p> <!-- Font size -->
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 lg:grid-cols-2 sm:gap-4">
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-4 mb-6">
                    <div
                        class="bg-black text-white p-4 rounded-lg shadow-md text-center transition-transform transform hover:scale-100">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-stopwatch text-white text-sm"></i>
                                <span class="text-sm font-semibold text-white">Election Ends In:</span>
                            </div>

                            <div class="text-white">
                                <i class="fas fa-pause-circle text-xl"></i>
                                <i class="fas fa-stop-circle text-xl"></i>
                            </div>
                        </div>
                        <div id="countdown"
                             class="flex flex-row p-4 lg:px-6 justify-center items-center overflow-x-auto space-x-4 lg:space-x-14 text-white">
                            <!-- Responsive gap -->
                            <div class="text-center">
                                <div id="days" class="text-2xl lg:text-4xl font-bold">02</div>
                                <div class="text-xs mt-1">DAYS</div>
                            </div>

                            <div class="text-center">
                                <div id="hours" class="text-2xl lg:text-4xl font-bold">10</div>
                                <div class="text-xs mt-1">HOURS</div>
                            </div>

                            <div class="text-center">
                                <div id="minutes" class="text-2xl lg:text-4xl font-bold">60</div>
                                <div class="text-xs mt-1">MINUTES</div>
                            </div>

                            <div class="text-center">
                                <div id="seconds" class="text-2xl lg:text-4xl font-bold">60</div>
                                <div class="text-xs mt-1">SECONDS</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white p-4 rounded-lg shadow-md w-full max-w-3xl transition-transform transform hover:scale-100">
                        <div class="flex items-center space-x-2">

                            <span class="text-center text-sm font-semibold">Votes Information</span>
                        </div>
                        <!-- <p class="text-xs text-gray-400">As of mm-dd-yyyy hh:mm:ss am</p>  -->
                        <div class="flex flex-wrap justify-around mt-4">
                            <div class="flex flex-col items-center ">
                                <div class="relative w-16 h-16">
                                    <!-- SVG Progress Circle -->
                                    <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 36 36">
                                        <path class="text-gray-200"
                                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                              fill="none" stroke-width="3" stroke="currentColor"></path>
                                        <path id="circular-progress-1" class="text-red-500"
                                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                              fill="none" stroke-width="3" stroke-dasharray="81, 100"
                                              stroke="currentColor"></path>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-sm font-semibold text-gray-800">81%</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-gray-700 text-xs font-bold">Total Votes</p>
                            </div>
                            <div class="flex flex-col items-center ">
                                <div class="relative w-16 h-16">
                                    <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 36 36">
                                        <path class="text-gray-200"
                                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                              fill="none" stroke-width="3" stroke="currentColor"></path>
                                        <path id="circular-progress-2" class="text-pink-500"
                                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                              fill="none" stroke-width="3" stroke-dasharray="22, 100"
                                              stroke="currentColor"></path>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-sm font-semibold text-gray-800">22%</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-gray-700 text-xs font-bold">Remaining Votes</p>
                            </div>
                            <div class="flex flex-col items-center ">
                                <div class="relative w-16 h-16">
                                    <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 36 36">
                                        <path class="text-gray-200"
                                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                              fill="none" stroke-width="3" stroke="currentColor"></path>
                                        <path id="circular-progress-3" class="text-blue-500"
                                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                              fill="none" stroke-width="3" stroke-dasharray="62, 100"
                                              stroke="currentColor"></path>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-sm font-semibold text-gray-800">62%</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-gray-700 text-xs font-bold">Voter Turnout</p>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl w-full lg:h-[328px] mb-4">
                    <h1 class="text-center text-sm font-semibold mb-6">Campus Course Vote Turnout</h1>
                    <div class="flex flex-col md:flex-row justify-center mb-4">
                        <div class="w-full md:w-2/5">
                            <canvas id="voteChart"
                                    style="display: block; box-sizing: border-box; height: 150px; width: 208px;"
                                    width="208" height="150"></canvas>
                        </div>
                        <div class="w-full md:w-2/2 md:pl-2 mt-2 md:mt-0 ">
                            <ul class="space-y-2 text-xs">
                                <li class="flex items-center  font-medium">
                                    <span class="w-4 h-4 bg-purple-600 inline-block mr-2"></span>
                                    <span>Bachelor of Science in Information Technology</span>
                                </li>
                                <li class="flex items-center  font-medium">
                                    <span class="w-4 h-4 bg-indigo-600 inline-block mr-2"></span>
                                    <span>Bachelor of Science in Agriculture and Biosystems Engineering</span>
                                </li>
                                <li class="flex items-center  font-medium">
                                    <span class="w-4 h-4 bg-blue-600 inline-block mr-2"></span>
                                    <span>Bachelor of Elementary Education</span>
                                </li>
                                <li class="flex items-center  font-medium">
                                    <span class="w-4 h-4 bg-yellow-500 inline-block mr-2"></span>
                                    <span>Bachelor of Secondary Education</span>
                                </li>
                                <li class="flex items-center  font-medium">
                                    <span class="w-4 h-4 bg-orange-500 inline-block mr-2"></span>
                                    <span>Bachelor of Early Childhood Education</span>
                                </li>
                                <li class="flex items-center  font-medium">
                                    <span class="w-4 h-4 bg-pink-500 inline-block mr-2"></span>
                                    <span>Bachelor of Special Needs Education</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-600 font-medium italic">
                        Note: This pie chart provides a detailed illustration of the campus vote turnout,
                        broken down by each course. The data represented here is live, meaning it is continually updated
                        to
                        reflect the most current vote counts for each course. This real-time aspect allows viewers to
                        see the
                        most accurate and up-to-date voting trends across the campus.
                    </p>
                </div>


            </div>


            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-8">


                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <!-- First Card -->
                    <div class="bg-white shadow-md rounded-lg p-6 w-full">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-sm font-semibold">Vote Tally</h2>
                            <span class="text-xs text-gray-500">Position <i class="fas fa-chevron-down"></i></span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Tagum Student Council</p>
                        <div class="flex items-center mb-4">
                            <img alt="Candidate's photo" class="w-10 h-10 rounded-full mr-4" height="40"
                                 src="https://storage.googleapis.com/a1aa/image/jf1Ozudbg43eVEqoknjodHhQdRbLI5LWukyTprdtIfGaA1MnA.jpg"
                                 width="40"/>
                            <div>
                                <p class="font-medium text-sm">Candidates Name</p>
                                <p class="text-xs text-gray-500">Yanong Agila</p>
                            </div>
                            <p class="ml-auto font-medium text-sm">56 votes</p>
                        </div>
                        <div class="flex items-center mb-20">
                            <div class="w-10 h-10 bg-gray-200 rounded-full mr-4"></div>
                            <div>
                                <p class="font-medium text-sm">Abstain</p>
                                <p class="text-xs text-gray-500">-</p>
                            </div>
                            <p class="ml-auto font-medium text-sm">12 votes</p>
                        </div>
                        <a class="text-gray-800 text-sm flex items-center" href="#">View more <i
                                class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <!-- Second Card -->
                    <div class="bg-white shadow-md rounded-lg p-6 w-full">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-sm font-semibold">Vote Tally</h2>
                            <span class="text-xs text-gray-500">Organization <i class="fas fa-chevron-down mr-2"></i> Position <i
                                    class="fas fa-chevron-down"></i></span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Local Council</p>
                        <div class="flex items-center mb-4">
                            <img alt="Candidate's photo" class="w-10 h-10 rounded-full mr-4" height="40"
                                 src="https://storage.googleapis.com/a1aa/image/jf1Ozudbg43eVEqoknjodHhQdRbLI5LWukyTprdtIfGaA1MnA.jpg"
                                 width="40"/>
                            <div>
                                <p class="font-medium text-sm">Candidates Name</p>
                                <p class="text-xs text-gray-500">Yanong Agila</p>
                            </div>
                            <p class="ml-auto font-medium text-sm">56 votes</p>
                        </div>
                        <div class="flex items-center mb-20">
                            <div class="w-10 h-10 bg-gray-200 rounded-full mr-4"></div>
                            <div>
                                <p class="font-medium text-sm">Abstain</p>
                                <p class="text-xs text-gray-500">-</p>
                            </div>
                            <p class="ml-auto font-medium text-sm">12 votes</p>
                        </div>
                        <a class="text-gray-800 text-sm flex items-center" href="#">View more <i
                                class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <script>
            //campus turnout
            const ctx = document.getElementById('voteChart').getContext('2d');
            const voteChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                        'Bachelor of Science in Information Technology',
                        'Bachelor of Science in Agriculture and Bio-systems Engineering',
                        'Bachelor of Elementary Education',
                        'Bachelor of Secondary Education',
                        'Bachelor of Early Childhood Education',
                        'Bachelor of Special Needs Education'
                    ],
                    datasets: [{
                        data: [10, 20, 30, 25, 15, 5],
                        backgroundColor: [
                            '#6B46C1',
                            '#5A67D8',
                            '#3182CE',
                            '#ECC94B',
                            '#ED8936',
                            '#D53F8C'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

        </script>
    </x-slot>
</x-app-layout>



