<div>
    <div class="hidden sm:block mb-4">
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
    <div class="flex w-full gap-4 min">
        <div id="Student and Local Council Election" class="w-full">
            <div class="flex-1 mb-3">
                <label for="candidate_election" class="text-xs font-semibold block mb-1">Select Election</label>
                <select name="selectedElection" id="candidate_election"
                        class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full "
                        wire:model.live="selectedElection">
                    <option value="" selected>Select an election</option>
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
            <div class="bg-white shadow-md rounded p-6">
                <div
                    class="flex text-[12px] bg-white mt-0 p-5 rounded-md md:max-w-[800px] min-[90%]:max-w-[100%] lg:max-w-[900px] xl:w-[100%] xl:min-w-[100%] 2xl:max-w-[1190px]">
                    <div class="flex w-full">
                        <div class="w-1/2">
                            <button
                                class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
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
                                            fill="#35353A"/>
                                    </g>
                                </svg>
                            </button>
                            <button
                                class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
                                <svg width="12" height="18" viewBox="0 0 22 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 1H1L9 10.46V17L13 19V10.46L21 1Z" stroke="#534D59"
                                          stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                            </button>
                            <button
                                class="bg-white border border-gray-100 rounded p-1 w-[30px] flex-row  items-center justify-items-center">
                                <svg width="12" height="18" viewBox="0 0 16 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.42969 1.60984V4.87942C9.42969 5.32273 9.42969 5.54439 9.5185 5.71372C9.59662 5.86266 9.72128 5.98375 9.8746 6.05964C10.0489 6.14592 10.2771 6.14592 10.7334 6.14592H14.0992M5.35547 11.6868L7.8 14.0615M7.8 14.0615L10.2445 11.6868M7.8 14.0615L7.8 9.31211M9.42969 1.39648H5.1925C3.82343 1.39648 3.1389 1.39648 2.61599 1.65531C2.15602 1.88298 1.78205 2.24626 1.54769 2.69309C1.28125 3.20106 1.28125 3.86604 1.28125 5.19599V13.4282C1.28125 14.7582 1.28125 15.4232 1.54769 15.9311C1.78205 16.378 2.15602 16.7412 2.61599 16.9689C3.1389 17.2277 3.82343 17.2277 5.1925 17.2277H10.4075C11.7766 17.2277 12.4611 17.2277 12.984 16.9689C13.444 16.7412 13.8179 16.378 14.0523 15.9311C14.3187 15.4232 14.3187 14.7582 14.3187 13.4282V6.14586L9.42969 1.39648Z"
                                        stroke="#534D59" stroke-width="1.8625" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>

                    </div>

                    <livewire:superadmin.add-candidates/>
                    <div class="relative w-[250px] mb-4">
                        <!-- Search Input -->
                        <input type="text" wire:model.live="search"
                               class="rounded h-[30px] text-[12px] border border-gray-400 pl-10 pr-4 focus:border-black focus:ring focus:ring-black-[1px] w-full"
                               placeholder="Search..." aria-label="Search">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg width="12" height="12" viewBox="0 0 14 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.68208 10.7458C8.66576 11.5361 7.38866 12.0067 6.00167 12.0067C2.68704 12.0067 0 9.31891 0 6.00335C0 2.68779 2.68704 0 6.00167 0C9.31631 0 12.0033 2.68779 12.0033 6.00335C12.0033 7.39059 11.533 8.66794 10.743 9.6845L13.7799 12.7186C14.0731 13.0115 14.0734 13.4867 13.7806 13.7799C13.4878 14.0731 13.0128 14.0734 12.7196 13.7805L9.68208 10.7458ZM10.5029 6.00335C10.5029 8.49002 8.48765 10.5059 6.00167 10.5059C3.5157 10.5059 1.50042 8.49002 1.50042 6.00335C1.50042 3.51668 3.5157 1.50084 6.00167 1.50084C8.48765 1.50084 10.5029 3.51668 10.5029 6.00335Z"
                                          fill="#868FA0"/>
                                </svg>
                            </span>
                    </div>

                </div>


                <div class="w-full h-full">
                    <h3 class="text-[12px] font-semibold px-4 py-2">STUDENT COUNCIL CANDIDATES</h3>
                    <!-- Student Council Section -->
                    <div id="studentCouncil"
                         class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 px-4 py-4">
                        @foreach($candidates as $candidate)
                            @if($candidate->election_positions->position->electionType->name == 'Student Council Election')
                                <div class="bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] min-h-[310px]">
                                    <div class="flex justify-center items-center">
                                        <p class="text-[12px]">Running for: <span
                                                class="text-red-900 uppercase tracking-wide font-semibold">{{ $candidate->election_positions->position->name }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <div class="flex justify-end mt-2">
                                            <img class="w-[80px]"
                                                 src="{{ asset('storage/assets/icon/usep_logo_svg.png') }}" alt="">
                                        </div>
                                        <div class="mt-[-38px] flex justify-center">
                                            <div class="border-2 border-black">
                                                <img class="w-[110px]"
                                                     src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="">
                                            </div>
                                        </div>

                                        <div class="mt-2 text-center">
                                            <div class="flex justify-center">
                                                <p class="text-black uppercase font-black text-[11px]">{{ $candidate->users->first_name }} {{ $candidate->users->middle_initial }}
                                                    . {{ $candidate->users->last_name }}</p>
                                            </div>
                                            <p class="text-black capitalize font-semibold text-[10px]">{{ $candidate->users->year_level }}
                                                year</p>
                                            <p class="text-black capitalize font-semibold text-[10px] leading-none">{{ $candidate->users->program->name }}</p>
                                            <p class="text-black capitalize font-semibold text-[11px] leading-none">{{ optional($candidate->users->programMajor)->name ?? '' }}</p>
                                            <p class="text-black mt-2 capitalize italic font-semibold text-[11px]">{{ $candidate->partyLists->name }}</p>


                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach

                    </div>


                    <h3 class="text-[12px] font-semibold mt-3 px-4 py-2">LOCAL COUNCIL CANDIDATES</h3>
                    <!-- Local Council Section -->
                    <div id="studentCouncil" class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 px-4 py-4">
                        @foreach($candidates as $candidate)
                            @if($candidate->election_positions->position->electionType->name == 'Local Council Election')
                                <div class="bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] min-h-[310px]">
                                    <div class="flex justify-center items-center">
                                        <p class="text-[12px]">Running for: <span
                                                class="text-red-900 uppercase tracking-wide font-semibold">{{ $candidate->election_positions->position->name }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <div class="flex justify-end mt-2">
                                            <img class="w-[80px]"
                                                 src="{{ asset('storage/assets/icon/usep_logo_svg.png') }}" alt="">
                                        </div>
                                        <div class="mt-[-38px] flex justify-center">
                                            <div class="border-2 border-black">
                                                <img class="w-[110px]"
                                                     src="{{ asset('storage/assets/profile/cat_meme.jpg') }}" alt="">
                                            </div>
                                        </div>

                                        <div class="mt-2 text-center">
                                            <div class="flex justify-center">
                                                <p class="text-black uppercase font-black text-[11px]">{{ $candidate->users->first_name }} {{ $candidate->users->middle_initial }}
                                                    . {{ $candidate->users->last_name }}</p>
                                            </div>
                                            <p class="text-black capitalize font-semibold text-[10px]">{{ $candidate->users->year_level }}
                                                year</p>
                                            <p class="text-black capitalize font-semibold text-[10px] leading-none">{{ $candidate->users->program->name }}</p>
                                            <p class="text-black capitalize font-semibold text-[11px] leading-none">{{ optional($candidate->users->programMajor)->name ?? '' }}</p>
                                            <p class="text-black mt-2 capitalize italic font-semibold text-[11px]">{{ $candidate->partyLists->name }}</p>


                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach

                    </div>

                </div>

            </div>
        </div>

    </div>

</div>
