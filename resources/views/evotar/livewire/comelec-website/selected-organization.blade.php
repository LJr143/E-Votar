<div>
    <div class="bg-gray-600 flex items-center justify-center p-8">

        <div class="container mx-auto py-8 md:px-4">
            <div class="flex items-center text-white space-x-4">
                <div class="text-[12px]">
                    {{ $election->campus->name ?? 'No Campus' }}
                </div>
                <div class="text-[12px]">
                    @if ($election)
                        {{ $election->date_started ? \Carbon\Carbon::parse($election->date_started)->format('M d, Y') : '' }} -
                        {{ $election->date_ended ? \Carbon\Carbon::parse($election->date_ended)->format('M d, Y') : '' }}
                    @else
                        <span>No election dates available</span>
                    @endif
                </div>


            </div>
            <div class="mt-4">
                <h1 class="text-[20px] font-bold text-white capitalize">
                    {{ $election->name ?? '' }}
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
                <livewire:selected-election.candidates-in-website :councilId="$council->id"/>

            </div>
            <div x-show="activeTab === 1" class="tab-content">
                <livewire:selected-election.vote-tally-in-website wire:key="vote-tally-{{ $council->id }}" :councilId="$council->id"/>
            </div>

            <div x-show="activeTab === 2" class="tab-content">
                <livewire:selected-election.election-result-in-website wire:key="election-result-{{ $council->id}}" :councilId="$council->id"/>
            </div>
        </div>
    </div>
</div>
