<div>
    <div class="bg-gray-600 flex items-center justify-center p-8">

        <div class="container mx-auto py-8 md:px-4">
            <div class="flex items-center text-white space-x-4">
                <div class="text-[12px]">
                    Tagum Unit
                </div>
                <div class="text-[12px]">
                    Jan 04, 2025 - Jan 10, 2025
                </div>
            </div>
            <div class="mt-4">
                <h1 class="text-[20px] font-bold text-white">
                    Tagum Student Council and Local Council Election 2025
                </h1>
            </div>


        </div>
    </div>
    <div x-data="{ activeTab: 0 }" class="w-full text-center">
        <div class="flex justify-center">
            <div @click="activeTab = 0" :class="activeTab === 0 ? 'border-b-2 border-white' : 'opacity-50'" class="tab bg-black text-white py-2 px-4 w-full cursor-pointer text-[12px]">
                Candidates
            </div>
            <div @click="activeTab = 1" :class="activeTab === 1 ? 'border-b-2 border-white' : 'opacity-50'" class="tab bg-black text-white py-2 px-4 w-full cursor-pointer text-[12px]">
                Vote Tally
            </div>
            <div @click="activeTab = 2" :class="activeTab === 2 ? 'border-b-2 border-white' : 'opacity-50'" class="tab bg-black text-white py-2 px-4 w-full cursor-pointer text-[12px]">
                Elected Officials
            </div>
        </div>
        <div class="tab-content-container mt-4 text-[12px]">
            <div x-show="activeTab === 0" class="tab-content">
                <livewire:selected-election.candidates-in-website/>

            </div>
            <div x-show="activeTab === 1" class="tab-content">
                <livewire:selected-election.vote-tally-in-website/>
            </div>

            <div x-show="activeTab === 2" class="tab-content">
                <livewire:selected-election.election-result-in-website/>
            </div>
        </div>
    </div>
</div>
