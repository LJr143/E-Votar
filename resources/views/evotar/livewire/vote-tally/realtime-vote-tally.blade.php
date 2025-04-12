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
                @foreach($elections as $election)
                    <option value="{{ $election->id }}" {{ $election->id == $selectedElection ? 'selected' : '' }}>
                        {{ $election->name }} - {{ $election->campus->name }} - {{$election->election_type->name }}
                    </option>
                @endforeach
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
                            <button
                                class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_782_22521" style="mask-type:alpha"
                                          maskUnits="userSpaceOnUse"
                                          x="0" y="0" width="24" height="24">
                                        <rect width="24" height="24" fill="#D9D9D9"/>
                                    </mask>
                                    <g mask="url(#mask0_782_22521)">
                                        <path
                                            d="M8.30826 20.4998C7.81115 20.4998 7.38559 20.3228 7.03159 19.9688C6.67757 19.6148 6.50056 19.1893 6.50056 18.6921V16.4998H4.59674C4.09962 16.4998 3.67406 16.3228 3.32006 15.9688C2.96606 15.6148 2.78906 15.1893 2.78906 14.6921V10.8075C2.78906 10.0992 3.03105 9.50548 3.51501 9.02632C3.99898 8.54717 4.59031 8.30759 5.28901 8.30759H18.7121C19.4204 8.30759 20.0141 8.54717 20.4933 9.02632C20.9724 9.50548 21.212 10.0992 21.212 10.8075V14.6921C21.212 15.1893 21.035 15.6148 20.681 15.9688C20.327 16.3228 19.9015 16.4998 19.4043 16.4998H17.5005V18.6921C17.5005 19.1893 17.3235 19.6148 16.9695 19.9688C16.6155 20.3228 16.1899 20.4998 15.6928 20.4998H8.30826ZM4.59674 14.9999H6.50056C6.5134 14.514 6.69493 14.0976 7.04516 13.7508C7.3954 13.404 7.81643 13.2306 8.30826 13.2306H15.6928C16.1846 13.2306 16.6057 13.404 16.9559 13.7508C17.3061 14.0976 17.4877 14.514 17.5005 14.9999H19.4043C19.4941 14.9999 19.5678 14.971 19.6255 14.9133C19.6832 14.8556 19.7121 14.7819 19.7121 14.6921V10.8075C19.7121 10.5242 19.6162 10.2867 19.4246 10.095C19.2329 9.90338 18.9954 9.80754 18.7121 9.80754H5.28901C5.00568 9.80754 4.76818 9.90338 4.57651 10.095C4.38485 10.2867 4.28901 10.5242 4.28901 10.8075V14.6921C4.28901 14.7819 4.31786 14.8556 4.37556 14.9133C4.43326 14.971 4.50699 14.9999 4.59674 14.9999ZM16.0005 8.30759V5.61529C16.0005 5.52554 15.9717 5.45182 15.914 5.39412C15.8563 5.33643 15.7826 5.30759 15.6928 5.30759H8.30826C8.21851 5.30759 8.14479 5.33643 8.08709 5.39412C8.02939 5.45182 8.00054 5.52554 8.00054 5.61529V8.30759H6.50056V5.61529C6.50056 5.11819 6.67757 4.69263 7.03159 4.33862C7.38559 3.98462 7.81115 3.80762 8.30826 3.80762H15.6928C16.1899 3.80762 16.6155 3.98462 16.9695 4.33862C17.3235 4.69263 17.5005 5.11819 17.5005 5.61529V8.30759H16.0005ZM17.8082 12.3075C18.0915 12.3075 18.329 12.2117 18.5207 12.02C18.7124 11.8284 18.8082 11.5909 18.8082 11.3075C18.8082 11.0242 18.7124 10.7867 18.5207 10.595C18.329 10.4034 18.0915 10.3075 17.8082 10.3075C17.5249 10.3075 17.2874 10.4034 17.0957 10.595C16.904 10.7867 16.8082 11.0242 16.8082 11.3075C16.8082 11.5909 16.904 11.8284 17.0957 12.02C17.2874 12.2117 17.5249 12.3075 17.8082 12.3075ZM16.0005 18.6921V15.0383C16.0005 14.9486 15.9717 14.8749 15.914 14.8172C15.8563 14.7595 15.7826 14.7306 15.6928 14.7306H8.30826C8.21851 14.7306 8.14479 14.7595 8.08709 14.8172C8.02939 14.8749 8.00054 14.9486 8.00054 15.0383V18.6921C8.00054 18.7819 8.02939 18.8556 8.08709 18.9133C8.14479 18.971 8.21851 18.9999 8.30826 18.9999H15.6928C15.7826 18.9999 15.8563 18.971 15.914 18.9133C15.9717 18.8556 16.0005 18.7819 16.0005 18.6921Z"
                                            fill="#000000"/>
                                    </g>
                                </svg>
                            </button>
                            <button
                                class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none">
                                <svg width="12" height="21" viewBox="0 0 18 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11 1.25605V5.18007C11 5.71212 11 5.97814 11.109 6.18136C11.2049 6.36011 11.3578 6.50544 11.546 6.59652C11.7599 6.70007 12.0399 6.70007 12.6 6.70007H16.7305M6 13.35L9 16.2M9 16.2L12 13.35M9 16.2L9 10.5M11 1H5.8C4.11984 1 3.27976 1 2.63803 1.31063C2.07354 1.58387 1.6146 2.01987 1.32698 2.55613C1 3.16578 1 3.96385 1 5.56V15.44C1 17.0361 1 17.8342 1.32698 18.4439C1.6146 18.9801 2.07354 19.4161 2.63803 19.6894C3.27976 20 4.11984 20 5.8 20H12.2C13.8802 20 14.7202 20 15.362 19.6894C15.9265 19.4161 16.3854 18.9801 16.673 18.4439C17 17.8342 17 17.0362 17 15.44V6.7L11 1Z"
                                        stroke="#000000" stroke-width="1.8625" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>

                            </button>
                            <button
                                class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none"
                                onclick="toggleFilter()">
                                <svg width="14" height="21" viewBox="0 0 23 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.5 1.5H1.5L9.5 10.96V17.5L13.5 19.5V10.96L21.5 1.5Z" stroke="#000000"
                                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
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
