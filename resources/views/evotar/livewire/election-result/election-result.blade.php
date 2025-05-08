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
                <option value="" disabled>Select an election</option>
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

    <div class="bg-white p-6 text-[11px] md:text-[12px] mt-4 shadow-md rounded w-full">
        <div class=" mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center mb-2">
                <div class="flex items-center justify-between flex-wrap md:flex-nowrap gap-2">
                    <button
                        class="bg-white border border-gray-300 rounded h-8 px-3 py-2 flex items-center space-x-1 hover:drop-shadow hover:bg-gray-200 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110"
                        wire:click="exportElectionResult"
                        wire:loading.attr="disabled">
                        <svg wire:loading.remove wire:target="exportElectionResult" xmlns="http://www.w3.org/2000/svg"
                             height="20px" viewBox="0 -960 960 960"
                             width="20px" fill="#000000">
                            <path
                                d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.72-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.16 50.85Q725.68-192 695.96-192H263.72Z"/>
                        </svg>
                        <span wire:loading.remove wire:target="exportElectionResult" class="text-[12px]">Export Election Result</span>
                        <svg wire:loading wire:target="exportElectionResult" class="animate-spin h-5 w-5 mr-3"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading wire:target="exportElectionResult">Exporting...</span>
                    </button>
                </div>
                <div class="flex flex-col sm:flex-row sm:justify-center  w-full md:w-auto mt-2">
                    <div class="relative sm:w-[250px] mb-4">
                        <input type="text" placeholder="Search..." aria-label="Search"
                               class="rounded-md text-[10px] border bg-white text-black border-gray-300 h-8 pl-8 pr-4 focus:ring-1 focus:ring-black focus:border-black w-full">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg width="12" height="12" viewBox="0 0 14 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z"
                                    fill="#000000"/>
                    </svg>
                                            </span>
                    </div>
                </div>
            </div>

            <div>

                @if($selectedElection)
                    @if($latestElection != 'ongoing')
                        <div class="space-y-8">
                            <!-- Election Summary Card -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                <div class="bg-indigo-600 px-4 py-3">
                                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">
                                        {{ $selectedElectionName }} Summary
                                    </h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Voters</p>
                                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalVoters }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Voters Turnout</p>
                                        <p class="text-2xl font-bold text-gray-900 mt-1">
                                            @if($totalVoters > 0)
                                                {{ number_format(($totalVoterVoted / $totalVoters) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $totalVoterVoted }} out of {{ $totalVoters }} voted
                                        </p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Abstentions</p>
                                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ array_sum($abstainCounts) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Student Council Results -->
                            @if ($hasStudentCouncilPositions && $studentCouncilWinners != null)
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                    <div class="bg-indigo-600 px-4 py-3">
                                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider">
                                            {{ $selectedElectionCampus->name ?? 'No campus available' }} Student Council Results
                                        </h3>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Winner</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Party</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Votes</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abstentions</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($studentCouncilWinners as $winner)
                                                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $winner['position'] }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                        {{ $winner['candidate'] ? $winner['candidate']->users->first_name . ' ' . $winner['candidate']->users->last_name : 'No winner' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $winner['candidate'] ? $winner['candidate']->partyLists->name : '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $winner['candidate'] ? $winner['candidate']->votes_count : '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $abstainCounts[$winner['position_id']] ?? 0 }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- Local Council Results -->
                            @if ($hasLocalCouncilPositions && $localCouncilWinners != null)
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                    <div class="bg-indigo-600 px-4 py-3">
                                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider">
                                            {{ $selectedElectionCampus->name ?? 'No campus available' }} Local Council Results
                                        </h3>
                                    </div>

                                    @foreach ($localCouncilWinners as $council => $winners)
                                        @php
                                            $winnersByMajor = collect($winners)->groupBy(function ($winner) {
                                                return $winner['major'] ?? 'N/A';
                                            });
                                        @endphp

                                        <div class="border-b border-gray-200 last:border-b-0">
                                            <div class="px-4 py-3 bg-gray-50">
                                                <h4 class="text-xs font-semibold text-gray-700 uppercase tracking-wider">{{ $council }}</h4>
                                            </div>

                                            @foreach ($winnersByMajor as $major => $majorWinners)
                                                @if ($major !== 'N/A')
                                                    <div class="px-4 py-2 bg-gray-100">
                                                        <h5 class="text-xs font-medium text-gray-600 uppercase">Major: {{ $major }}</h5>
                                                    </div>
                                                @endif

                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Winner</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Party</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Votes</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abstentions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach ($majorWinners as $winner)
                                                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $winner['position'] }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                                    {{ $winner['candidate'] ? $winner['candidate']->users->first_name . ' ' . $winner['candidate']->users->last_name : 'No winner' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{ $winner['candidate'] ? $winner['candidate']->partyLists->name : '-' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{ $winner['candidate'] ? $winner['candidate']->votes_count : '-' }}
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                    {{ $abstainCounts[$winner['position_id']] ?? 0 }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Election in Progress</h3>
                                    <div class="mt-1 text-sm text-yellow-700">
                                        <p>Results will be available once the election period has concluded.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No election selected</h3>
                        <p class="mt-1 text-sm text-gray-500">Please select an election to view results.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

