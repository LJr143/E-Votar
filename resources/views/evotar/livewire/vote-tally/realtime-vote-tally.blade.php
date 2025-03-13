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
        </div>
        <div class="mt-4 w-full">
            <div x-show="tab === 'per-position'">
                <div class="bg-white shadow-md rounded p-6">

                    <div class="w-full">
                        <div class="container mx-auto px-4 py-4">
                            <!-- Student Council Section -->
                            <h2 class="text-[16px] font-bold uppercase text-center mb-4">{{ $selectedElectionCampus->name ?? 'No campus available' }}
                                Student Council Candidates</h2>
                            <div id="studentCouncil"
                                 class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 px-4 py-4"
                                 wire:key="student-council-list" wire:poll="$refresh">
                                @foreach($candidates->where('election_positions.position.electionType.name', 'Student Council Election') as $candidate)
                                    <div wire:key="candidate-{{ $candidate->id }}">
                                        <div class="bg-white p-6 shadow-md min-h-[320px]">
                                            <p class="text-black font-bold text-[10px] mt-2 uppercase">Votes: {{ $candidate->votes_count }}</p>
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
                            <!-- Local Councils Section -->
                            <h2 class="text-[16px] font-bold uppercase text-center mt-8 mb-4">Local Councils Candidates</h2>
                            @foreach($candidates->where('election_positions.position.electionType.name', 'Local Council Election')->groupBy('users.program.council.name') as $programName => $localCandidates)
                                <h3 class="text-[12px] px-4 font-bold uppercase text-gray-700 mt-6">{{ $programName }} Organization</h3>
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 px-4 py-4">
                                    @foreach($localCandidates as $candidate)
                                        <div wire:key="candidate-{{ $candidate->id }}">
                                            <div class="bg-white p-6 shadow-md min-h-[320px]">
                                                <p class="text-black font-bold text-[10px] mt-2 uppercase">Votes: {{ $candidate->votes_count }}</p>
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
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div x-show="tab === 'graphical'"  wire:poll="$refresh">

            <div class="bg-white p-4 rounded-lg shadow-lg w-full ">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-black" style="font-size: 14px;">Tagum Student Council</h2>
                </div>
                <div class="flex justify-around mb-4">
                    <div class="text-center">
                        <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Voters</h4>
                        <p class="text-lg text-black" style="font-size: 12px;">{{ $totalVoters }}</p>
                    </div>
                    <div class="border-l border-gray-300 mx-4"></div>
                    <div class="text-center">
                        <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Who Voted</h4>
                        <p class="text-lg text-black" style="font-size: 12px;">{{ $totalVoterVoted }}</p>
                    </div>
                    <div class="border-l border-gray-300 mx-4"></div>
                    <div class="text-center">
                        <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Who Did Not
                            Vote</h4>
                        <p class="text-lg text-black" style="font-size: 12px;">{{ $totalVoters - $totalVoterVoted }}</p>
                    </div>
                </div>
                <div class="relative h-full">
                    <livewire:charts.vote-chart-student-council :electionId="$selectedElection"/>
                </div>
            </div>

                <livewire:charts.vote-chart-local-council :electionId="$selectedElection"/>

        </div>

        <div x-show="tab === 'tabulated'">
            <div class="bg-white shadow-md rounded p-6">
                <div
                    class="text-[12px] bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-2">
                        <div class="flex space-x-2">
                            <button
                                class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none">

                            </button>
                            <button
                                class="bg-white border border-gray-300 w-8 h-8 rounded-md flex items-center justify-center hover:bg-gray-200 focus:outline-none">

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
                        <table class="min-w-full ">
                            <thead>
                            <tr class="w-full bg-gray-100 text-black uppercase text-[11px] leading-normal">
                                <th class="py-3 px-6 text-left rounded-tl-lg border-b border-gray-300">
                                    <input type="checkbox" class="form-checkbox h-4 w-4 text-black">
                                </th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Candidate</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Position</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Party list</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Program</th>
                                <th class="py-3 px-6 text-left border-b border-gray-300">Abstain Count</th>
                                <th class="py-3 px-6 text-left rounded-tr-lg border-b border-gray-300">Vote Tally</th>
                            </tr>
                            </thead>
                            <tbody class="text-black text-[12px] font-light">
                            <tr class="border-b border-gray-100 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">
                                    <input type="checkbox" class="form-checkbox h-4 w-4 text-black row-checkbox">
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="font-bold">Brooklyn Simmons</div>
                                </td>
                                <td class="py-3 px-6 text-left">President</td>
                                <td class="py-3 px-6 text-left">Yanong Agila</td>
                                <td class="py-3 px-6 text-left">Bachelor of Science in Information Technology</td>
                                <td class="py-3 px-6 text-left">17 votes</td>
                                <td class="py-3 px-6 text-left">
                                    <div class="font-bold">57 votes</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
