<x-app-layout mainClass="flex" headerClass="" page_title="- Dashboard">

    <x-slot name="sidebar">
        <x-sidebar></x-sidebar>
    </x-slot>

    <x-slot name="header">
        <x-header></x-header>
    </x-slot>
    <x-slot name="main">

        <div class="container mx-auto">
            <div class="flex flex-row justify-between items-start mb-4 ">
                <div class="mb-2 md:mb-0 text-left">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Dashboard</h1>
                    <p class=" text-gray-500 text-[11px]">Hi, {{ auth()->user()->first_name }} . Welcome back!</p>
                </div>
                <div class="relative bg-white p-2 rounded-lg shadow-md flex items-center cursor-pointer space-x-2">
                    <div class="bg-gray-200 p-2 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-gray-600 text-[11px]"></i>
                    </div>
                    <div>
                        <p class="text-gray-800 text-[10px] font-semibold">Election Title</p>
                        <p class="text-gray-600 text-[9px]">Year</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-600 text-[11px]"></i>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-1 w-full gap-4 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4  ">
                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center">
                        <div class="bg-black flex items-center justify-center rounded-full"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm text-gray-900 font-bold">0</h2>
                            <p class="text-[10px] mb-2 font-semibold text-gray-500">TOTAL VOTERS</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center">
                        <div class="bg-black flex items-center justify-center rounded-full"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm text-gray-900 font-bold">0</h2>
                            <p class="text-[10px] mb-2 font-semibold text-gray-500">TOTAL CANDIDATES</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center">
                        <div class="bg-black flex items-center justify-center rounded-full"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-users-cog text-white text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm text-gray-900 font-bold">{{ \App\Models\User::has('roles')->count() }}</h2>
                            <p class="text-[10px] mb-2 font-semibold text-gray-500">TOTAL SYSTEM USER</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center">
                        <div class="bg-black flex items-center justify-center rounded-full"
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-tasks text-white text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-sm text-gray-900 font-bold">0</h2>
                            <p class="text-[10px] mb-2 font-semibold text-gray-500">TOTAL POSITION</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 sm:gap-4">
                <div class="flex-row space-y-2 mb-6">
                    <div class="bg-black text-white p-4 rounded-lg shadow-md text-center min-h-[160px] ">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-stopwatch text-white text-sm"></i>
                                <span class="text-sm font-bold text-white">Election Ends In:</span>
                            </div>

                            <div class="text-white">
                                <i class="fas fa-pause-circle text-xl"></i>
                                <i class="fas fa-stop-circle text-xl"></i>
                            </div>
                        </div>
                        <div class="tick" data-did-init="handleTickInit">
                            <div
                                data-repeat="true"
                                data-layout="horizontal fit"
                                data-transform="preset(d, h, m, s) -> delay"
                                class="tick-container">

                                <div class="tick-group">
                                    <div data-key="value" data-repeat="true" data-transform="pad(00) -> split -> delay">
                                        <span data-view="flip" class="tick-value"></span>
                                    </div>
                                    <span data-key="label" data-view="text" class="tick-label"></span>
                                </div>
                            </div>
                            <div class="tick-onended-message" style="display: none">
                                <p>Time's up</p>
                            </div>
                        </div>

                    </div>

                    <div class="bg-white min-h-[160px] p-4 rounded-lg shadow-md w-full max-w-3xl transition-transform transform hover:scale-100">
                        <div class="flex items-center space-x-2">
                            <span class="text-center text-sm font-bold">Votes Information</span>
                        </div>
                        <div class="flex flex-wrap justify-around mt-4">
                            <div class="flex flex-col items-center ">
                                <div class="relative w-16 h-16">
                                    <!-- SVG Progress Circle -->
                                    <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 36 36">
                                        <path class="text-gray-200"
                                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                              fill="none" stroke-width="3" stroke="currentColor"></path>
                                        <path id="circular-progress-1" class="text-red-600"
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
                                        <path id="circular-progress-2" class="text-gray-500"
                                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                              fill="none" stroke-width="3" stroke-dasharray="22, 100"
                                              stroke="currentColor"></path>
                                    </svg>
                                    <div class="absolute inset-0 top-1 flex items-center justify-center">
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
                                        <path id="circular-progress-3" class="text-red-400"
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


                <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl w-full lg:h-[340px] mb-4">
                    <h1 class="text-sm font-bold mb-6">Campus Course Vote Turnout</h1>
                    <div class="flex flex-col md:flex-row justify-center mb-4">
                        <div class="w-full md:w-2/5">
                            <canvas id="voteChart"
                                    style="display: block; box-sizing: border-box; height: 150px; width: 208px;"
                                    width="208" height="150"></canvas>
                        </div>
                        <div class="w-full md:w-2/2 md:pl-2 mt-2 md:mt-0">
                            <ul id="courseList" class="space-y-2 text-xs">
                                <!-- List items will be populated dynamically -->
                            </ul>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-600 font-medium italic">
                        Note: This pie chart provides a detailed illustration of the campus vote turnout,
                        broken down by each course. The data represented here is live, meaning it is continually updated
                        to reflect the most current vote counts for each course. This real-time aspect allows viewers to
                        see the most accurate and up-to-date voting trends across the campus.
                    </p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <!-- First Card -->
                <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-md">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                        <h1 class="text-sm font-bold mb-4 sm:mb-0">
                            Candidates
                        </h1>

                    </div>
                </div>

            </div>

            <div class="flex flex-row justify-between text-gray-500 text-[10px] mt-4">
                <i>Copyright@2025</i>
                <i>E-Votar@2024</i>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('voteChart').getContext('2d');
            fetch('/labels')  // Fetch data from your backend
                .then(response => response.json())
                .then(data => {
                    const labels = data.labels;  // Labels fetched from the backend
                    const colors = data.colors;  // Colors fetched from the backend (if available)
                    const votes = data.votes;    // Data for the chart (e.g., vote counts)

                    // Dynamically populate the list with course names and their colors
                    const courseList = document.getElementById('courseList');
                    courseList.innerHTML = ''; // Clear existing content
                    labels.forEach((label, index) => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('flex', 'items-center', 'font-medium');
                        listItem.innerHTML = `
                    <span class="w-4 h-4 mr-1" style="background-color: ${colors[index]};"></span>
                    <span>${label}</span>
                `;
                        courseList.appendChild(listItem);
                    });

                    // Create the chart with dynamic data
                    const voteChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,  // Dynamic labels
                            datasets: [{
                                data: votes,  // Dynamic data
                                backgroundColor: colors,  // Dynamic colors
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
                })
                .catch(error => console.error('Error fetching labels and data:', error));
        </script>
        <script>
            function handleTickInit(tick) {
                // Fetch the data from the API
                fetch('/api/election-end-time')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch election data');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.end_time) {
                            // Initialize the countdown counter
                            var counter = Tick.count.down(data.end_time);

                            counter.onupdate = function (value) {
                                tick.value = value;
                            };

                            counter.onended = function () {
                                alert('Election countdown ended!');
                            };
                        } else {
                            console.error('No end time found');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error.message);
                    });
            }
        </script>
    </x-slot>
</x-app-layout>



