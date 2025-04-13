<div class="flex flex-col items-start space-y-4 w-full px-0">
    <div class="hidden sm:block mb-2">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click="$set('filter', 'Student and Local Council Election')"
                        class=" whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'Student and Local Council Election' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Student and Local Council Election
                </button>
                <button wire:click="$set('filter', 'Student Council Election')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'Student Council Election' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Student Council Election
                </button>
                <button wire:click="$set('filter', 'Local Council Election')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'Local Council Election' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Local Council Election
                </button>
                <button wire:click="$set('filter', 'Special Election')"
                        class="whitespace-nowrap border-b-2 pb-1 px-1 text-[10px] font-medium {{ $filter === 'Special Election' ? 'border-black text-black' : 'text-gray-500 hover:text-black' }}">
                    Special Election
                </button>
            </nav>
        </div>
    </div>
    <div class="w-full">
        <div class="flex-1 mb-3">
            <label for="candidate_election" class="text-xs font-semibold block mb-1">Select Election</label>
            <select name="selectedElection" id="candidate_election"
                    class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full "
                    wire:model.live="selectedElection">
                <option value="" selected disabled>Select an election</option>
                @if($selectedElection)
                    @foreach($elections as $election)
                        <option
                            value="{{ $election->id }}" {{ $election->id == $selectedElection ? 'selected' : '' }}>
                            {{ $election->name }} - {{ $election->campus->name }}
                            - {{$election->election_type->name }}
                        </option>
                    @endforeach
                @else
                    <option value="" selected>No Election Created Yet</option>
                @endif
            </select>
            @error('selectedElection')
            <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class=" w-full" x-data="{ tab: 'per-position' }">
        <div class="flex items-center space-x-2">
                        <span class="text-gray-500 text-[11px]">
                         View as:
                        </span>
            <div class="flex border border-gray-300 rounded-lg overflow-hidden text-[11px] w-auto">
                <div
                    :class="{ 'bg-black text-white font-bold': tab === 'per-position', 'text-gray-800': tab !== 'per-position' }"
                    @click="tab = 'per-position'" class="px-4 py-2 cursor-pointer">
                    Per Position
                </div>
                <div
                    :class="{ 'bg-black text-white font-bold': tab === 'graphical', 'text-gray-800': tab !== 'graphical' }"
                    @click="tab = 'graphical'" class="px-4 py-2 cursor-pointer">
                    Graphical
                </div>
                <div
                    :class="{ 'bg-black text-white font-bold': tab === 'tabulated', 'text-gray-800': tab !== 'tabulated' }"
                    @click="tab = 'tabulated'" class="px-4 py-2 cursor-pointer">
                    Tabulated
                </div>
            </div>
            <div class="flex items-center justify-between flex-wrap md:flex-nowrap gap-2">
                <button
                    class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                    wire:click="exportVoteTally"
                    wire:loading.attr="disabled">
                    <svg wire:loading.remove wire:target="exportVoteTally" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                         width="20px" fill="#000000">
                        <path
                            d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                    </svg>
                    <span wire:loading.remove wire:target="exportVoteTally" class="text-[12px]">Export Vote Tallying Result</span>
                    <svg wire:loading wire:target="exportVoteTally" class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading wire:target="exportVoteTally">Exporting...</span>
                </button>
            </div>
        </div>
        <div class="mt-4 w-full">
            <div x-show="tab === 'per-position'">
                <div class="bg-white shadow-md rounded p-6">

                    <div class="w-full">
                        <div class="container mx-auto px-4 py-4">
                            @if($selectedElection)
                            <!-- Student Council Section -->
                            @if(!auth()->user()->hasRole('local-council-watcher'))
                            @if($hasStudentCouncilPositions && $hasStudentCouncilCandidate)
                                <h2 class="text-[16px] font-bold uppercase text-center mb-4">{{ $selectedElectionCampus->name ?? 'No campus available' }}
                                    Student Council Candidates</h2>
                                <div id="studentCouncil"
                                     class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 px-4 py-4"
                                     wire:key="student-council-list" wire:poll="$refresh">
                                    @foreach($candidates->where('election_positions.position.electionType.name', 'Student Council Election') as $candidate)
                                        <div wire:key="candidate-{{ $candidate->id }}">
                                            <div class="bg-white p-6 shadow-md min-h-[320px]">
                                                <p class="text-black font-bold text-[10px] mt-2 uppercase">
                                                    Votes: {{ $candidate->votes_count }}</p>
                                                <div class="flex justify-center items-center">
                                                    <p class="text-[12px]">Running for:
                                                        <span class="text-red-900 uppercase tracking-tighter font-semibold">
                                {{ $candidate->election_positions->position->name }}
                            </span>
                                                    </p>
                                                </div>
                                                <div>
                                                    <div class="flex justify-end mt-2 mr-[15px]">
                                                        <img class="w-[85px]"
                                                             src="{{ asset('storage/assets/icon/usep_logo_svg.png') }}"
                                                             alt="">
                                                    </div>
                                                    <div class="mt-[-38px] flex justify-center">
                                                        <div class="border-2 border-black">
                                                            <img class="w-[110px]"
                                                                 src="{{ asset('storage/assets/profile/cat_meme.jpg') }}"
                                                                 alt="">
                                                        </div>
                                                    </div>

                                                    <div class="mt-2 text-center">
                                                        <div class="flex justify-center">
                                                            <p class="text-black uppercase font-black text-[11px]">{{ $candidate->users->first_name }} {{ $candidate->users->middle_initial }}
                                                                . {{ $candidate->users->last_name }}</p>
                                                        </div>
                                                        <p class="text-black capitalize font-semibold text-[10px]">{{ $candidate->users->year_level }}
                                                            year</p>
                                                        <p class="text-black capitalize font-semibold text-[12px] leading-none">
                                                            @php
                                                                $programName = $candidate->users->program->name;
                                                                $programName = str_starts_with($programName, 'Bachelor of Science') ? 'BS ' . substr($programName, strlen('Bachelor of Science')) : $programName;
                                                            @endphp
                                                            <span class="program-name !text-[12px]"
                                                                  title="{{ $programName }}">
                                                {{ $programName }}
                                            </span>
                                                        </p>
                                                        <p class="text-black capitalize font-semibold text-[11px] leading-none">{{ optional($candidate->users->programMajor)->name ?? '' }}</p>
                                                        <p class="text-black mt-2 capitalize italic font-semibold text-[11px]">{{ $candidate->partyLists->name }}</p>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @endif
                            <!-- Local Councils Section -->
                            @if(!auth()->user()->hasRole('student-council-watcher'))
                            @if($hasLocalCouncilPositions && $hasLocalCouncilCandidate)
                                <h2 class="text-[16px] font-bold uppercase text-center mt-8 mb-4">Local Councils
                                    Candidates</h2>
                                @foreach($candidates->where('election_positions.position.electionType.name', 'Local Council Election')->groupBy('users.program.council.name') as $programName => $localCandidates)
                                    <h3 class="text-[12px] px-4 font-bold uppercase text-gray-700 mt-6">{{ $programName }}
                                        Organization</h3>
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 px-4 py-4">
                                        @foreach($localCandidates as $candidate)
                                            <div wire:key="candidate-{{ $candidate->id }}">
                                                <div class="bg-white p-6 shadow-md min-h-[320px]">
                                                    <p class="text-black font-bold text-[10px] mt-2 uppercase">
                                                        Votes: {{ $candidate->votes_count }}</p>
                                                    <div class="flex justify-center items-center">
                                                        <p class="text-[12px] text-center">Running for:
                                                            <span
                                                                class="text-red-900 uppercase tracking-tighter font-semibold">
                                                                    {{ $candidate->election_positions->position->name }}
                                                        </span>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <div class="flex justify-end mt-2 mr-[15px]">
                                                            <img class="w-[85px]"
                                                                 src="{{ asset('storage/assets/icon/usep_logo_svg.png') }}"
                                                                 alt="">
                                                        </div>
                                                        <div class="mt-[-38px] flex justify-center">
                                                            <div class="border-2 border-black">
                                                                <img class="w-[110px]"
                                                                     src="{{ asset('storage/assets/profile/cat_meme.jpg') }}"
                                                                     alt="">
                                                            </div>
                                                        </div>

                                                        <div class="mt-2 text-center">
                                                            <div class="flex justify-center">
                                                                <p class="text-black uppercase font-black text-[11px]">{{ $candidate->users->first_name }} {{ $candidate->users->middle_initial }}
                                                                    . {{ $candidate->users->last_name }}</p>
                                                            </div>
                                                            <p class="text-black capitalize font-semibold text-[10px]">{{ $candidate->users->year_level }}
                                                                year</p>
                                                            <p class="text-black capitalize font-semibold text-[12px] leading-none">
                                                                @php
                                                                    $programName = $candidate->users->program->name;
                                                                    $programName = str_starts_with($programName, 'Bachelor of Science') ? 'BS ' . substr($programName, strlen('Bachelor of Science')) : $programName;
                                                                @endphp
                                                                <span class="program-name !text-[12px]"
                                                                      title="{{ $programName }}">
                                                {{ $programName }}
                                            </span>
                                                            </p>
                                                            <p class="text-black capitalize font-semibold text-[11px] leading-none">{{ optional($candidate->users->programMajor)->name ?? '' }}</p>
                                                            <p class="text-black mt-2 capitalize italic font-semibold text-[11px]">{{ $candidate->partyLists->name }}</p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif
                            @endif
                            @else
                                <div class="border border-gray-200 rounded-md p-8 text-center">
                                    <div class="flex justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 opacity-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    </div>
                                    <h3 class="text-[14px] font-medium mb-2">No currently created election</h3>
                                </div>
                            @endif
                           </div>

                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'graphical'" wire:poll="$refresh">

            <div>
                <!-- Student Council Chart -->
                @if(!auth()->user()->hasRole('local-council-watcher'))
                @if ($hasStudentCouncilPositions)
                    <livewire:charts.vote-chart-student-council :electionId="$selectedElection"/>
                @endif
                @endif

                <!-- Local Council Chart -->
                @if(!auth()->user()->hasRole('student-council-watcher'))
                @if ($hasLocalCouncilPositions)
                    <livewire:charts.vote-chart-local-council :electionId="$selectedElection"/>
                @endif
                @endif
            </div>

        </div>

        <div x-show="tab === 'tabulated'">
            <div class="bg-white shadow-md rounded p-6">
                <div
                    class="text-[12px] bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-2">
                        <div class="flex space-x-2">
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-center  w-full md:w-auto mt-2">
                            <div class="relative sm:w-[250px] mb-4">
                                <input type="text" placeholder="Search..." aria-label="Search"
                                       class="rounded-md text-[10px] border bg-white text-black border-gray-300 h-8 pl-8 pr-4 focus:ring-1 focus:ring-black focus:border-black w-full">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2">

                                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-4 min-h-[350px]">
                        <div class="mt-4 min-h-[400px]">
                            <div class="space-y-6">
                                <!-- Student Council Election -->
                                @if(!auth()->user()->hasRole('local-council-watcher'))
                                @if ($hasStudentCouncilPositions)
                                    <div x-data="{ open: false }" class="bg-white shadow-lg rounded-lg p-4" wire:key="student-council">
                                        <div class="flex w-full justify-center items-center">
                                            <h2 class="text-[16px] font-bold uppercase text-center mb-4">
                                                {{ $selectedElectionCampus->name ?? 'No campus available' }} Student Council Candidates
                                            </h2>
                                        </div>

                                        <div class="mt-3 text-[12px]">
                                            @foreach ($candidates->where('election_positions.position.electionType.name', 'Student Council Election')->groupBy('election_positions.position.name') as $position => $candidatesForPosition)
                                                <div class="bg-gray-100 p-3 rounded mt-2" wire:key="position-{{ $position }}">
                                                    <span class="font-semibold">{{ $position }}</span>
                                                    <div class="mt-2 space-y-2">
                                                        @foreach ($candidatesForPosition as $candidate)
                                                            <div class="flex justify-between items-center bg-white p-2 rounded">
                                                                <span>{{ $candidate->users->first_name }} {{ $candidate->users->last_name }}</span>
                                                                <span class="font-bold">{{ $candidate->votes_count }} votes</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @endif

                                <!-- Local Council Election -->
                                @if(!auth()->user()->hasRole('student-council-watcher'))
                                @if ($hasLocalCouncilPositions)
                                    <div x-data="{ open: false }" class="bg-white shadow-lg rounded-lg p-4" wire:key="local-council">
                                        <div class="flex w-full justify-center items-center">
                                            <h2 class="text-[16px] font-bold uppercase text-center mb-4">
                                                {{ $selectedElectionCampus->name ?? 'No campus available' }} Local Council Candidates
                                            </h2>
                                        </div>

                                        <div class="mt-3 text-[12px]">
                                            <!-- Group candidates by council (program) -->
                                            @foreach ($candidates->where('election_positions.position.electionType.name', 'Local Council Election')->groupBy('users.program.council.name') as $council => $candidatesForCouncil)
                                                <div class="bg-gray-100 p-3 rounded mt-2" wire:key="council-{{ $council }}">
                                                    <span class="font-semibold">{{ $council }}</span>
                                                    <div class="mt-2 space-y-2">
                                                        <!-- Group candidates by position within the council -->
                                                        @foreach ($candidatesForCouncil->groupBy('election_positions.position.name') as $position => $candidatesForPosition)
                                                            <div class="bg-gray-50 p-2 rounded">
                                                                <span class="font-medium">{{ $position }}</span>
                                                                <div class="mt-1 space-y-1">
                                                                    @foreach ($candidatesForPosition as $candidate)
                                                                        <div class="flex justify-between items-center bg-white p-2 rounded">
                                                                            <span>{{ $candidate->users->first_name }} {{ $candidate->users->last_name }}</span>
                                                                            <span class="font-bold">{{ $candidate->votes_count }} votes</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @endif
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function initChart(canvasId, eventName) {
            const ctx = document.getElementById(canvasId).getContext('2d');

            // Initialize the chart with empty data
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: 'black' },
                            grid: { color: 'rgba(0, 0, 0, 0.1)' }
                        },
                        x: {
                            ticks: { color: 'black' },
                            grid: { color: 'rgba(0, 0, 0, 0.1)' }
                        }
                    },
                    plugins: {
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: 'black',
                            bodyColor: 'black',
                            borderColor: 'rgba(0, 0, 0, 0.1)',
                            borderWidth: 1
                        },
                        legend: { display: false },
                        datalabels: {
                            display: true,
                            align: 'end',
                            anchor: 'end',
                            formatter: (value, context) => {
                                if (value === 0) return null;
                                return `${context.dataset.label}: ${value} votes`;
                            },
                            color: 'black',
                            font: { weight: 'bold' }
                        }
                    }
                }
            });

            // Listen for Livewire events to update the chart
            Livewire.on(eventName, chartData => {
                console.log(`🔥 Raw Chart Data Received for ${canvasId}:`, chartData);

                if (Array.isArray(chartData) && chartData.length > 0) {
                    chartData = chartData[0];
                }

                console.log(`📌 Extracted Chart Data for ${canvasId}:`, chartData);

                if (!chartData || !chartData.labels || !chartData.datasets) {
                    console.error(`❌ Invalid chart data received for ${canvasId}!`);
                    return;
                }

                if (!chartData.labels.length || !chartData.datasets.length) {
                    console.warn(`⚠️ No valid data to display for ${canvasId}!`);
                    return;
                }

                // ✅ Assign totalVoters safely
                let totalVoters = chartData.totalVoters ?? 100; // Default to 100 if undefined

                // Update chart data
                chart.data.labels = chartData.labels;
                chart.data.datasets = chartData.datasets;

                // ✅ Update y-axis max dynamically
                chart.options.scales.y.max = totalVoters;
                chart.options.scales.y.ticks.stepSize = Math.ceil(totalVoters / 10);

                chart.update();

                console.log(`✅ Chart Updated Successfully for ${canvasId} with totalVoters:`, totalVoters);
            });

            return chart;
        }
    </script>
</div>
