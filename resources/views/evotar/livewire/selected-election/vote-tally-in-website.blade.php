<div class="container mx-auto px-4 py-8" x-data="tabsData()">
    <!-- Tabs -->
    <div class="flex justify-center mb-6">
        <div class="inline-flex rounded-md shadow-sm" role="group">
            <button
                @click="activeTab = 'tsc'"
                :class="activeTab === 'tsc' ? 'bg-black text-white' : 'bg-white text-gray-800 hover:bg-gray-100'"
                class="px-6 py-2 text-sm font-medium border border-gray-200 rounded-l-lg focus:z-10 focus:outline-none transition-colors duration-200"
            >
                Tagum Student Council
            </button>
            <button
                @click="activeTab = 'lc'"
                :class="activeTab === 'lc' ? 'bg-black text-white' : 'bg-white text-gray-800 hover:bg-gray-100'"
                class="px-6 py-2 text-sm font-medium border border-gray-200 rounded-r-lg focus:z-10 focus:outline-none transition-colors duration-200"
            >
                Local Council
            </button>
        </div>
    </div>

    <!-- TSC Content -->
    <div x-show="activeTab === 'tsc'" x-transition>
        <div class="px-4 md:px-12 pt-8">
            <h1 class="text-center text-gray-800 text-[14px] sm:text-[16px] md:text-[18px] font-bold mb-6 sm:mb-8">TAGUM STUDENT COUNCIL VOTE TALLY</h1>

            <div x-data="tscElectionData()">
                <!-- President and VP for Internal Affairs -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <!-- President -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[0].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in positions[0].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                        <div class="absolute top-0 right-0 bg-gray-800 text-white text-[10px] px-2 py-1" x-text="candidate.department"></div>
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(positions[0]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(positions[0]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${positions[0].abstainVotes} (${calculatePercentage(positions[0].abstainVotes, getTotalVotes(positions[0]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(positions[0].abstainVotes, getTotalVotes(positions[0]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- VP for Internal Affairs -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[1].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in positions[1].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                        <div class="absolute top-0 right-0 bg-gray-800 text-white text-[10px] px-2 py-1" x-text="candidate.department"></div>
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(positions[1]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(positions[1]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${positions[1].abstainVotes} (${calculatePercentage(positions[1].abstainVotes, getTotalVotes(positions[1]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(positions[1].abstainVotes, getTotalVotes(positions[1]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VP for External Affairs and General Secretary -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <!-- VP for External Affairs -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[2].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in positions[2].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                        <div class="absolute top-0 right-0 bg-gray-800 text-white text-[10px] px-2 py-1" x-text="candidate.department"></div>
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(positions[2]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(positions[2]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${positions[2].abstainVotes} (${calculatePercentage(positions[2].abstainVotes, getTotalVotes(positions[2]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(positions[2].abstainVotes, getTotalVotes(positions[2]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- General Secretary -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[3].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in positions[3].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                        <div class="absolute top-0 right-0 bg-gray-800 text-white text-[10px] px-2 py-1" x-text="candidate.department"></div>
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(positions[3]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(positions[3]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${positions[3].abstainVotes} (${calculatePercentage(positions[3].abstainVotes, getTotalVotes(positions[3]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(positions[3].abstainVotes, getTotalVotes(positions[3]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- General Treasurer and General Auditor -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <!-- General Treasurer -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[4].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in positions[4].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                        <div class="absolute top-0 right-0 bg-gray-800 text-white text-[10px] px-2 py-1" x-text="candidate.department"></div>
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(positions[4]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(positions[4]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${positions[4].abstainVotes} (${calculatePercentage(positions[4].abstainVotes, getTotalVotes(positions[4]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(positions[4].abstainVotes, getTotalVotes(positions[4]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- General Auditor -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[5].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in positions[5].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                        <div class="absolute top-0 right-0 bg-gray-800 text-white text-[10px] px-2 py-1" x-text="candidate.department"></div>
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(positions[5]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(positions[5]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${positions[5].abstainVotes} (${calculatePercentage(positions[5].abstainVotes, getTotalVotes(positions[5]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(positions[5].abstainVotes, getTotalVotes(positions[5]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PIO -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <!-- PIO -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[6].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in positions[6].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                        <div class="absolute top-0 right-0 bg-gray-800 text-white text-[10px] px-2 py-1" x-text="candidate.department"></div>
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(positions[6]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(positions[6]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${positions[6].abstainVotes} (${calculatePercentage(positions[6].abstainVotes, getTotalVotes(positions[6]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(positions[6].abstainVotes, getTotalVotes(positions[6]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LC Content -->
    <div x-show="activeTab === 'lc'" x-transition>
        <div class="px-4 md:px-12 pt-8">
            <h1 class="text-center text-gray-800 text-[14px] sm:text-[16px] md:text-[18px] font-bold mb-6 sm:mb-8">LOCAL COUNCIL VOTE TALLY</h1>
            <div class="container mx-auto p-4" x-data="{ activeFilter: 'SABES' }">
                <!-- Filter Options -->
                <div class="mb-6">
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                        <h3 class="text-[14px] font-bold text-black mb-3">Filter Options</h3>
                        <div class="flex flex-wrap gap-2 sm:gap-3 justify-center">
                            <template x-for="option in ['SABES', 'SITS', 'AFSET', 'OFEE', 'BECEd', 'BSNEd', 'BTVTEd']" :key="option">
                                <button
                                    @click="activeFilter = option"
                                    :class="activeFilter === option ? 'bg-gray-800 text-white' : 'bg-white text-gray-800 border-gray-300'"
                                    class="px-3 py-1 text-xs font-medium border rounded-full focus:outline-none transition-colors duration-200 whitespace-nowrap"
                                >
                                    <span x-text="option"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Section Title -->
                <div class="flex items-center justify-center mt-10 mb-4">
                    <div class="h-1 w-24 bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mr-4"></div>
                    <h2 class="text-gray-800 text-[16px] font-semibold text-center">
                        <template x-if="activeFilter === 'SABES'">
                            <span>SOCIETY OF AGRICULTURAL BIOSYSTEMS ENGINEERING STUDENTS (SABES)</span>
                        </template>
                        <template x-if="activeFilter === 'SITS'">
                            <span>SOCIETY OF INFORMATION TECHNOLOGY STUDENTS (SITS)</span>
                        </template>
                        <template x-if="activeFilter === 'AFSET'">
                            <span>ASSOCIATION OF FUTURE SECONDARY EDUCATION TEACHERS (AFSET)</span>
                        </template>
                        <template x-if="activeFilter === 'OFEE'">
                            <span>ORGANIZATION OF FUTURE ELEMENTARY EDUCATORS (OFEE)</span>
                        </template>
                        <template x-if="activeFilter === 'BECEd'">
                            <span>BACHELOR OF EARLY CHILDHOOD EDUCATION (BECEd)</span>
                        </template>
                        <template x-if="activeFilter === 'BSNEd'">
                            <span>BACHELOR OF SPECIAL NEEDS EDUCATION (BSNEd)</span>
                        </template>
                        <template x-if="activeFilter === 'BTVTEd'">
                            <span>BACHELOR OF TECHNICAL VOCATIONAL TEACHER EDUCATION (BTVTEd)</span>
                        </template>
                    </h2>
                    <div class="h-1 w-24 bg-gradient-to-r from-transparent via-[#8B0000] to-transparent ml-4"></div>
                </div>
            </div>

            <div x-data="lcElectionData()">
                <!-- Governor  and Vice Governor -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <!-- Governor -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[0].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in filteredPositions[0].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[0]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[0]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${filteredPositions[0].abstainVotes} (${calculatePercentage(filteredPositions[0].abstainVotes, getTotalVotes(filteredPositions[0]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(filteredPositions[0].abstainVotes, getTotalVotes(filteredPositions[0]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- Vice Governor -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[1].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in filteredPositions[1].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[1]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[1]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${filteredPositions[1].abstainVotes} (${calculatePercentage(filteredPositions[1].abstainVotes, getTotalVotes(filteredPositions[1]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(filteredPositions[1].abstainVotes, getTotalVotes(filteredPositions[1]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Auditor and Treasurer -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <!-- Auditor -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[2].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in filteredPositions[2].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[2]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[2]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${filteredPositions[2].abstainVotes} (${calculatePercentage(filteredPositions[2].abstainVotes, getTotalVotes(filteredPositions[2]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(filteredPositions[2].abstainVotes, getTotalVotes(filteredPositions[2]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- Treasurer -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[3].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in filteredPositions[3].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[3]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[3]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${filteredPositions[3].abstainVotes} (${calculatePercentage(filteredPositions[3].abstainVotes, getTotalVotes(filteredPositions[3]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(filteredPositions[3].abstainVotes, getTotalVotes(filteredPositions[3]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secretary and Legislator -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <!-- Secretary -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[4].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in filteredPositions[4].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[4]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[4]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${filteredPositions[4].abstainVotes} (${calculatePercentage(filteredPositions[4].abstainVotes, getTotalVotes(filteredPositions[4]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(filteredPositions[4].abstainVotes, getTotalVotes(filteredPositions[4]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- Legislator -->
                    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full sm:w-1/2">
                        <h2 class="text-[14px] font-bold text-black mb-4 pb-2 border-b border-gray-200" x-text="positions[5].title"></h2>

                        <div class="flex flex-wrap gap-3 mb-6">
                            <template x-for="candidate in filteredPositions[5].candidates" :key="candidate.id">
                                <div class="bg-white rounded border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow h-full w-full sm:w-[calc(50%-6px)] lg:w-[calc(33.333%-8px)]">
                                    <div class="aspect-[3/2] relative bg-gray-100 h-[150px] w-full">
                                        <img :src="candidate.imageUrl" :alt="candidate.name" class="w-full h-full object-cover">
                                    </div>

                                    <div class="p-2">
                                        <h3 class="text-[12px] font-semibold text-black mb-1" x-text="candidate.name"></h3>

                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[11px] text-gray-600" x-text="candidate.party"></span>
                                            <span class="text-[11px] font-medium" x-text="`${candidate.votes}`"></span>
                                        </div>

                                        <div class="mt-1">
                                            <div class="flex justify-between text-[11px] mb-1">
                                                <span class="text-[11px]">Votes</span>
                                                <span class="text-[11px] font-medium" x-text="`${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[5]))}%`"></span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div
                                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                                    :style="`width: ${calculatePercentage(candidate.votes, getTotalVotes(filteredPositions[5]))}%; background: linear-gradient(to right, #000000, #CCCCCC);`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-4 pt-2 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[11px] font-medium text-gray-700">Abstain</h3>
                                <span class="text-[11px] font-semibold" x-text="`${filteredPositions[5].abstainVotes} (${calculatePercentage(filteredPositions[5].abstainVotes, getTotalVotes(filteredPositions[5]))}%)`"></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div
                                    class="h-2 rounded-full transition-all duration-500 ease-out"
                                    :style="`width: ${calculatePercentage(filteredPositions[5].abstainVotes, getTotalVotes(filteredPositions[5]))}%; background: linear-gradient(to right, #A52A2A, #D98880)`"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function tabsData() {
        return {
            activeTab: 'tsc'
        }
    }

    function tscElectionData() {
        return {
            positions: [
                {
                    id: 1,
                    title: "PRESIDENT",
                    candidates: [
                        {
                            id: 1,
                            name: "Jane Smith",
                            party: "Yanong Agila",
                            department: "SABES",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 1245,
                        }
                    ],
                    abstainVotes: 145,
                },
                {
                    id: 2,
                    title: "VP FOR INTERNAL AFFAIRS",
                    candidates: [
                        {
                            id: 2,
                            name: "Sarah Williams",
                            department: "SABES",
                            party: "Yanong Agila",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 1156,
                        },
                        {
                            id: 3,
                            name: "Michael Brown",
                            department: "SITS",
                            party: "Paragon",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 1032,
                        },
                    ],
                    abstainVotes: 231,
                },
                {
                    id: 3,
                    title: "VP FOR EXTERNAL AFFAIRS",
                    candidates: [
                        {
                            id: 4,
                            name: "Emily Davis",
                            party: "Yanong Agila",
                            department: "SABES",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 987,
                        },
                        {
                            id: 5,
                            name: "David Wilson",
                            party: "Paragon",
                            department: "SITS",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 876,
                        },
                    ],
                    abstainVotes: 178,
                },
                {
                    id: 4,
                    title: "GENERAL SECRETARY",
                    candidates: [
                        {
                            id: 6,
                            name: "Daniel Taylor",
                            party: "Yanong Agila",
                            department: "SABES",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 1089,
                        },
                        {
                            id: 7,
                            name: "Sophia Anderson",
                            party: "Paragon",
                            department: "AFSET",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 954,
                        },
                    ],
                    abstainVotes: 198,
                },
                {
                    id: 5,
                    title: "GENERAL TREASURER",
                    candidates: [
                        {
                            id: 8,
                            name: "James Wilson",
                            party: "Yanong Agila",
                            department: "SITS",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 876,
                        },
                        {
                            id: 9,
                            name: "Emma Thompson",
                            party: "Paragon",
                            department: "AFSET",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 932,
                        },
                        {
                            id: 10,
                            name: "Lucas Garcia",
                            party: "Independent",
                            department: "OFEE",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 743,
                        },
                    ],
                    abstainVotes: 156,
                },
                {
                    id: 6,
                    title: "GENERAL AUDITOR",
                    candidates: [
                        {
                            id: 11,
                            name: "Ava Robinson",
                            party: "Yanong Agila",
                            department: "BECEd",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 1023,
                        },
                        {
                            id: 12,
                            name: "Noah Clark",
                            party: "Paragon",
                            department: "BSNEd",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 967,
                        },
                    ],
                    abstainVotes: 187,
                },
                {
                    id: 7,
                    title: "PUBLIC INFORMATION OFFICER",
                    candidates: [
                        {
                            id: 13,
                            name: "Isabella Lee",
                            party: "Yanong Agila",
                            department: "SABES",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 845,
                        },
                        {
                            id: 14,
                            name: "Ethan Wright",
                            party: "Paragon",
                            department: "BTVTEd",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 789,
                        },
                        {
                            id: 15,
                            name: "Mia Hernandez",
                            party: "Independent",
                            department: "SITS",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 912,
                        },
                    ],
                    abstainVotes: 203,
                },
            ],

            getTotalVotes(position) {
                const candidateVotes = position.candidates.reduce((sum, candidate) => sum + candidate.votes, 0);
                return candidateVotes + position.abstainVotes;
            },

            calculatePercentage(votes, total) {
                return total === 0 ? 0 : Math.round((votes / total) * 100);
            }
        };
    }

    function lcElectionData() {
        return {
            positions: [
                {
                    id: 1,
                    title: "GOVERNOR",
                    candidates: [
                        {
                            id: 1,
                            name: "Alex Johnson",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 845,
                        },
                        {
                            id: 2,
                            name: "Maria Rodriguez",
                            party: "Progress",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 756,
                        },
                        {
                            id: 3,
                            name: "Olivia Chen",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 712,
                        }
                    ],
                    abstainVotes: 178,
                },
                {
                    id: 2,
                    title: "VICE GOVERNOR",
                    candidates: [
                        {
                            id: 4,
                            name: "William Park",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 798,
                        },
                        {
                            id: 5,
                            name: "Emma Davis",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 689,
                        }
                    ],
                    abstainVotes: 156,
                },
                {
                    id: 3,
                    title: "AUDITOR",
                    candidates: [
                        {
                            id: 6,
                            name: "Daniel Kim",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 723,
                        },
                        {
                            id: 7,
                            name: "Isabella Lopez",
                            party: "Progress",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 678,
                        },
                        {
                            id: 8,
                            name: "Ava Thompson",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 645,
                        }
                    ],
                    abstainVotes: 143,
                },
                {
                    id: 4,
                    title: "TREASURER",
                    candidates: [
                        {
                            id: 9,
                            name: "Daniel Kim",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 723,
                        },
                        {
                            id: 10,
                            name: "Isabella Lopez",
                            party: "Progress",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 678,
                        },
                        {
                            id: 11,
                            name: "Ava Thompson",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 645,
                        }
                    ],
                    abstainVotes: 143,
                },
                {
                    id: 5,
                    title: "SECRETARY",
                    candidates: [
                        {
                            id: 12,
                            name: "Noah Garcia",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 687,
                        },
                        {
                            id: 13,
                            name: "Mia Nguyen",
                            party: "Progress",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 732,
                        },
                        {
                            id: 14,
                            name: "Charlotte Johnson",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 621,
                        }
                    ],
                    abstainVotes: 167,
                },
                {
                    id: 6,
                    title: "LEGISLATOR",
                    candidates: [
                        {
                            id: 15,
                            name: "Noah Garcia",
                            party: "Unity",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 687,
                        },
                        {
                            id: 16,
                            name: "Mia Nguyen",
                            party: "Progress",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 732,
                        },
                        {
                            id: 17,
                            name: "Mia Nguyen",
                            party: "Progress",
                            imageUrl: "{{ asset('storage/assets/profile/cat_meme.jpg') }}",
                            votes: 732,
                        }
                    ],
                    abstainVotes: 167,
                }
            ],
            filteredPositions: [],

            init() {
                this.filteredPositions = JSON.parse(JSON.stringify(this.positions));
            },

            getTotalVotes(position) {
                const candidateVotes = position.candidates.reduce((sum, candidate) => sum + candidate.votes, 0);
                return candidateVotes + position.abstainVotes;
            },

            calculatePercentage(votes, total) {
                return total === 0 ? 0 : Math.round((votes / total) * 100);
            }
        };
    }

    function filterLCCandidates(department) {
        const lcData = Alpine.store('lcData') || lcElectionData();

        if (department === 'all') {
            lcData.filteredPositions = JSON.parse(JSON.stringify(lcData.positions));
        } else {
            lcData.filteredPositions = lcData.positions.map(position => {
                const filteredPosition = {...position};
                filteredPosition.candidates = position.candidates.filter(candidate =>
                    candidate.department.toLowerCase() === department.toLowerCase()
                );
                return filteredPosition;
            });
        }

        Alpine.store('lcData', lcData);
    }
</script>
