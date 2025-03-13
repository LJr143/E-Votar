
<div x-data="{ open: false }" x-cloak @election-created.window="open = false">
    <!-- Trigger Button -->
    <button @click="open = true" class="w-[120px] h-8 rounded bg-gradient-to-b from-gray-800 to-black text-white text-[12px] flex items-center justify-center gap-2 hover:drop-shadow hover:bg-gray-700 hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#FFFFFF">
            <path d="M444-444H240v-72h204v-204h72v204h204v72H516v204h-72v-204Z"/>
        </svg>
        Add Election
    </button>

    <!-- Modal -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-white p-6 rounded shadow-md w-full mx-4 sm:mx-6 md:mx-8 lg:mx-10 xl:mx-12 overflow-y-auto max-h-[80vh]"
            :class="{ 'sm:w-[60%]': $wire.currentStep === 1, 'sm:w-[40%]': $wire.currentStep === 2 }"
        >



        <div class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
                <div>
                    <h2 class="text-sm font-bold text-left w-full sm:w-auto">Add Election</h2>
                    <p class="text-[10px] text-gray-500 italic">To add an election please fill out the required
                        information.</p>
                </div>

                <!-- Close Button (X) -->
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>


            <!-- Election Details-->
            @if ($currentStep === 1)
                <form wire:submit.prevent="proceedToVoters">
                    <div>
                        <div class="flex flex-col md:flex-row md:space-x-4">
                            <div class="flex-col w-full md:w-1/2">
                                <div class="mb-3">
                                    <label for="election_name" class="text-xs font-semibold block mb-1">
                                        Name (eg. Student and Local Election 2023)
                                    </label>
                                    <input id="election_name" type="text" placeholder="Student and Local Election 2023"
                                           class="border border-gray-300 text-xs rounded-lg px-4 py-2 w-full focus:ring-black focus:border-black"
                                           wire:model="election_name">

                                    @error('election_name')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="election_type" class="text-xs font-semibold block mb-1">
                                        Election Type
                                    </label>
                                    <select name="election_type" id="election_type" wire:model.live="election_type"
                                            class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full focus:ring-black focus:border-black">
                                        <option value="" selected>Select election type</option>
                                        @foreach($electionTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('election_type')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex-1 mb-3">
                                    <label for="election_campus" class="text-xs font-semibold block mb-1">Campus</label>
                                    <select name="election_campus" id="election_campus"
                                            class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full focus:ring-black focus:border-black "
                                            wire:model="election_campus">
                                        <option class="" value="" selected>Select campus for election</option>
                                        @foreach($campus as $camp)
                                            <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('election_campus')
                                    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p class="text-[12px] font-medium">Election Period</p>
                                <div class="flex flex-col md:flex-row md:space-x-4 mb-4 border border-gray-300 rounded-md p-4">
                                    <div class="flex-1 mb-3 md:mb-0 min-w-0">
                                        <label for="election_start" class="text-[10px] block mb-1">From</label>
                                        <input id="election_start" type="datetime-local"
                                               class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black"
                                               wire:model="election_start">
                                        @error('election_start')
                                        <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <label for="election_end" class="text-[10px] block mb-1">To</label>
                                        <input id="election_end" type="datetime-local"
                                               class="border border-gray-300 text-xs rounded-md px-4 py-2 w-full focus:ring-black focus:border-black"
                                               wire:model="election_end">
                                        @error('election_end')
                                        <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="flex-col h-[355px] w-full md:w-1/2  overflow-auto">
                                <div class="mb-4">
                                    <p class="text-xs font-semibold block mb-1">Available Positions</p>

                                    <!-- Student Council Positions -->
                                    @if(!empty($studentCouncilPositions))
                                        <p class="text-[11px] font-normal text-center mt-4 sm:mt-2 mb-2">Student Council Positions</p>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($studentCouncilPositions as $positionId => $positionName)
                                                @if(in_array($positionId, $selectedPositions))
                                                    <!-- Only show selected positions -->
                                                    <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center w-full">
                                                        <span class="text-[10px]">{{ $positionName }}</span>
                                                        <button type="button"
                                                                wire:click="removePosition({{ $positionId }})"
                                                                class="text-white px-2 py-1 rounded bg-red-500">
                                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9 1L1 9M9 9L1 0.999998" stroke="white"
                                                                      stroke-width="2" stroke-linecap="round"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Local Council Positions -->
                                    @if(!empty($localCouncilPositions) && $election_type != 2)
                                        <p class="text-[11px] font-normal text-center mb-2 mt-4">Local Council Positions</p>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($localCouncilPositions as $positionId => $positionName)
                                                @if(in_array($positionId, $selectedPositions))
                                                    <!-- Only show selected positions -->
                                                    <div
                                                        class="border border-gray-300 rounded-lg p-4 flex justify-between items-center w-full">
                                                        <span class="text-[10px]">{{ $positionName }}</span>
                                                        <button type="button"
                                                                wire:click="removePosition({{ $positionId }})"
                                                                class="text-white px-2 py-1 rounded bg-red-500">
                                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9 1L1 9M9 9L1 0.999998" stroke="white"
                                                                      stroke-width="2" stroke-linecap="round"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="mt-6 pt-3 flex justify-end space-x-2">
                            <button type="button"
                                    @click="open = false"
                                    class="bg-white text-black text-[12px] border border-gray-300 h-7 px-4 py-1 rounded shadow-md hover:bg-gray-200 justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                Proceed to Election Voter
                            </button>
                        </div>
                    </div>
                </form>

            @elseif ($currentStep === 2)
                <form wire:submit.prevent="submit">
                    <!-- Election Voters-->
                    <div>
                        <div>
                            <div class="mb-2">
                                <p class="text-[12px] font-semibold"> Manage election voter here</p>
                            </div>
                            <div>
                                <div class="min-h-[300px]">
                                    <div class="bg-white text-black p-4"> <!-- White background with black text -->
                                        <div class="mb-4">
                                            <p class="text-[12px] font-bold">Select Colleges and Programs</p> <!-- Title with bold font -->
                                        </div>

                                        <div>
                                            @foreach($colleges as $college)
                                                <div class="flex items-center mb-2"> <!-- Flex for alignment -->
                                                    <input type="checkbox" wire:model.live="selectedColleges"
                                                           value="{{ $college->id }}" id="college-{{ $college->id }}" class="mr-2"> <!-- Margin-right for spacing -->
                                                    <label for="college-{{ $college->id }}" class="text-[12px] font-semibold">{{ $college->name }}</label> <!-- College name with semi-bold font -->
                                                </div>

                                                @if(in_array($college->id, $selectedColleges))
                                                    <div class="mt-2 pl-6 mb-4"> <!-- Padding-left for indentation -->
                                                        <strong class="text-[12px] font-semibold">Programs for {{ $college->name }}</strong>
                                                        @foreach($programsByCollege[$college->id] ?? [] as $program)
                                                            <div class="ml-6 mb-1"> <!-- Margin-bottom for spacing between programs -->
                                                                <input type="checkbox" wire:model="selectedPrograms"
                                                                       value="{{ $program->id }}"
                                                                       id="program-{{ $program->id }}" class="mr-2"> <!-- Margin-right for spacing -->
                                                                <label for="program-{{ $program->id }}" class="text-[12px]">{{ $program->name }}</label> <!-- Program name with regular font -->
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-3 flex justify-end space-x-2">
                            <button type="button" wire:click="backToStep1"
                                    class="bg-white text-black text-[12px] border border-gray-300 h-7 px-4 py-1 rounded shadow-md hover:bg-gray-200 justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                Back
                            </button>
                            <button type="submit"
                                    class="bg-black text-white px-6 py-1 h-7 rounded shadow-md hover:bg-gray-700 text-[12px] justify-center text-center hover:drop-shadow hover:scale-105 hover:ease-in-out hover:duration-300 transition-all duration-300 [transition-timing-function:cubic-bezier(0.175,0.885,0.32,1.275)] active:-translate-y-1 active:scale-x-90 active:scale-y-110">
                                Save Election
                            </button>
                        </div>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
