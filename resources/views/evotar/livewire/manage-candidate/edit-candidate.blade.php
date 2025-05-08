<div x-data="{ open: false }" x-cloak @candidate-edited.window="open = false">
    <!-- Trigger Button -->
    <div>
        <button @click="open = true"
                class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
            <svg width="14" height="18" viewBox="0 0 17 17" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M1.49997 15.5H2.7615L12.9981 5.2634L11.7366 4.00188L1.49997 14.2385V15.5ZM0.90385 17C0.647767 17 0.433108 16.9133 0.259875 16.7401C0.0866248 16.5668 0 16.3522 0 16.0961V14.3635C0 14.1196 0.0467999 13.8871 0.1404 13.6661C0.233983 13.4451 0.362825 13.2526 0.526925 13.0885L13.1904 0.430775C13.3416 0.293426 13.5086 0.187292 13.6913 0.112375C13.874 0.0374582 14.0656 0 14.2661 0C14.4666 0 14.6608 0.0355838 14.8488 0.10675C15.0368 0.1779 15.2032 0.291034 15.348 0.44615L16.5692 1.68268C16.7243 1.82754 16.8349 1.99424 16.9009 2.18278C16.9669 2.37129 17 2.55981 17 2.74833C17 2.94941 16.9656 3.14131 16.8969 3.32403C16.8283 3.50676 16.719 3.67373 16.5692 3.82495L3.91147 16.473C3.74738 16.6371 3.55483 16.766 3.33383 16.8596C3.11281 16.9532 2.88037 17 2.6365 17H0.90385ZM12.3563 4.6437L11.7366 4.00188L12.9981 5.2634L12.3563 4.6437Z"
                    fill="green"/>
            </svg>

        </button>
    </div>
    <style>
        table td, th {
            font-size: 10px !important;
        }

        tr {
            height: 15px;
            line-height: 15px;
        }

        td, th {
            padding: 0;
        }

    </style>
    <!-- Modal -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-white p-6 rounded shadow-md w-2/5 max-h-[700px] z-[10000]"
        >

            <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Edit Candidate</h2>
                    @if($election->status == 'completed' || $election->status == 'ongoing')
                        <p class="text-[10px] text-gray-500 italic">
                            You are in <span class="text-red-600 font-semibold">read-only mode</span>. Updates are not permitted while the election is ongoing or has started.
                        </p>
                    @else
                    <p class="text-[10px] text-gray-500 italic">To edit a candidate please provide the required
                        information. note that candidates should be a valid voter.</p>
                    @endif
                </div>
                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="submit" readonly>
                <div>
                    <fieldset @disabled(in_array($election->status, ['completed', 'ongoing']))>
                    <div class="flex space-x-4 w-full">
                        <div x-data="{ isOpen: false }" class="flex-col w-full">
                            <div class="mb-3 relative">
                                <label for="candidate_name" class="text-xs font-semibold block mb-1">
                                    Name of Candidate (Note!: User Should Be A Voter)
                                </label>
                                <input
                                    type="text"
                                    id="candidate_name"
                                    placeholder="Search for a user"
                                    class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full"
                                    wire:model.live="search"
                                    x-on:focus="isOpen = true"
                                    x-on:blur="setTimeout(() => isOpen = false, 200)"
                                    autocomplete="off"
                                    readonly
                                />
                                <div x-show="isOpen && search.length > 0" class="flex z-10 bg-white border border-gray-300 rounded-lg w-full max-h-[50px] overflow-auto mt-[5px] shadow-lg">
                                    <div class="w-full">
                                        @if (!empty($users))
                                            @forelse ($users as $user)
                                                <div
                                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                                    wire:click="selectUser({{ $user->id }})"
                                                    x-on:click="isOpen = false"
                                                >
                                                    {{ $user->first_name }} {{ $user->middle_initial }}. {{ $user->last_name }}
                                                    - {{ $user->year_level }} {{ $user->program->name }}
                                                </div>
                                            @empty
                                                <li class="px-4 py-2 text-gray-500">No results found.</li>
                                            @endforelse
                                        @endif
                                    </div>
                                </div>

                                @error('selectedUser')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1 mb-3">
                                <label for="candidate_election" class="text-xs font-semibold block mb-1">Select Election</label>
                                <select name="candidate_election" id="candidate_election"
                                        class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full "
                                        wire:model.live="selectedElection">
                                    <option value="" selected>Select an election</option>
                                    @foreach($elections as $election)
                                        <option value="{{ $election->id }}">{{ $election->name }} - {{ $election->campus->name }} - {{$election->election_type->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedElection')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1 mb-3">
                                <label for="candidate_position" class="text-xs font-semibold block mb-1">Available Position</label>
                                <select name="candidate_position" id="candidate_position"
                                        class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full "
                                        wire:model="candidate_position">
                                    <option value="" selected>Select available election position</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->position->name }} - {{ $position->position->electionType->name }}</option>
                                    @endforeach
                                </select>
                                @error('candidate_position')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1 mb-3">
                                <label for="candidate_party_list" class="text-xs font-semibold block mb-1">Party list</label>
                                <select name="candidate_party_list" id="candidate_party_list"
                                        class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full "
                                        wire:model="candidate_party_list">
                                    <option value="" selected>Select a party list</option>
                                    @foreach($partyLists as $partyList)
                                        <option value="{{ $partyList->id }}">{{ $partyList->name }}</option>
                                    @endforeach
                                </select>
                                @error('candidate_party_list')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1 mb-3">
                                <label for="candidate_description" class="text-xs font-semibold block mb-1">About the Candidate (eg. Advocacy, Virtue)</label>
                                <textarea name="candidate_description" id="candidate_description"
                                          class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full min-h-[100px]" style="resize: none"
                                          wire:model="candidate_description"></textarea>
                                @error('candidate_party_list')
                                <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="mt-6 pt-3 flex justify-end space-x-2">
                        <button type="button"
                                class="bg-gray-300 text-gray-700 text-[12px] h-7 px-4 py-1 rounded shadow-md hover:bg-gray-400 justify-center text-center"
                                @click="open = false">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center">
                            Save Changes
                        </button>
                    </div>
                    </fieldset>
                </div>

            </form>

        </div>
    </div>
</div>
