<div class="mx-auto px-4 md:px-12 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-3/4">
            <!-- Partylist Header -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex items-center space-x-4">
                    @if($partylist->logo_path)
                        <img src="{{ asset('storage/'. $partylist->logo_path) }}"
                             alt="{{ $partylist->name }} logo"
                             class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $partylist->name }} Members</h1>
                        <p class="text-gray-600">
                            {{ $currentElectionCandidates->count() }} candidates in current election •
                            {{ $otherMembers->count() }} other members
                        </p>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Members</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input
                                wire:model.debounce.300ms="search"
                                type="text"
                                id="search"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                placeholder="Enter candidate name">
                        </div>
                    </div>
                    <div>
                        <label for="organization" class="block text-sm font-medium text-gray-700 mb-1">Filter by Organization</label>
                        <select wire:model.live="organizationFilter"  class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm">
                            <option value="">All Councils</option>
                            @foreach($councils as $council)
                                <option value="{{ $council->name }}">{{ $council->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Current Election Candidates -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Candidates in Current Election</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $currentElectionCandidates->count() }} candidates
                                </span>
                </div>

                @if($currentElectionCandidates->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No candidates found</h3>
                        <p class="mt-1 text-sm text-gray-500">This partylist has no candidates in the current election.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($currentElectionCandidates as $candidate)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="relative">
                                    <img
                                        src="{{ $candidate->users->profile_photo_path ? asset('storage/' . $candidate->users->profile_photo_path) : asset('storage/assets/logo/usep_logo.jpg') }}"
                                        alt="{{ $candidate->users->first_name }}"
                                        class="w-full h-48 object-cover">
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                        <h3 class="text-white font-bold text-lg">
                                            {{ $candidate->users?->first_name }}
                                            {{ $candidate->users?->middle_initial ? $candidate->users->middle_initial . '. ' : '' }}
                                            {{ $candidate->users?->last_name }}
                                            {{ $candidate->users?->extension ? ' ' . $candidate->uses->extension : '' }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800 mb-2">
                                                            {{ $candidate->election_positions->position->name ?? 'No Position' }}
                                                        </span>
                                            <p class="text-sm text-gray-600">{{ $candidate->users->program->council->name ?? 'No Organization' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Other Members -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Other Members</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $otherMembers->count() }} members
                                </span>
                </div>

                @if($otherMembers->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No other members found</h3>
                        <p class="mt-1 text-sm text-gray-500">All members are currently running in the election.</p>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <ul class="divide-y divide-gray-200">
                            @foreach($otherMembers as $member)
                                <li class="p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <div class="flex items-center space-x-4">
                                        <img
                                            src="{{ $member->user->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                                            alt="{{ $member->user->name }}"
                                            class="w-12 h-12 rounded-full object-cover">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $member->user->name }}</p>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ $member->position->name ?? 'Member' }} •
                                                {{ $member->organization ?? 'No Organization' }}
                                            </p>
                                        </div>
                                        <div>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            {{ $member->election->name ?? 'Past Election' }}
                                                        </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-1/4">
            <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">All Partylists</h2>
                <div class="space-y-3">
                    @foreach($allPartylists as $pl)
                        <a
                            href="{{ route('comelec-website.selected-partylist', $pl) }}"
                            class="block p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200 {{ $pl->id == $partylist->id ? 'bg-red-50 border border-red-200' : '' }}">
                            <div class="flex items-center space-x-3">
                                @if($pl->logo_path)
                                    <img src="{{ asset('storage/'.$pl->logo_path) }}"
                                         alt="{{ $pl->name }} logo"
                                         class="w-10 h-10 rounded-full object-cover">
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $pl->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $pl->candidates_count ?? 0 }} members
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
