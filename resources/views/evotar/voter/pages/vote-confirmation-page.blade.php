<x-app-layout mainClass="flex" headerClass="" page_title="- Vote Confirmed">

    <x-slot name="header">
        @if (!session('Admin-Voting-Access'))
        <div class="px-6 w-full">
            <x-evotar-components::voter.voter-header></x-evotar-components::voter.voter-header>
        </div>
        @endif
    </x-slot>
    <x-slot name="main">
        <div class="min-h-screen w-full flex justify-center  " style="background-color: #E8EBEE">
            <div>
                <div>
                    <img src="{{ asset('storage/assets/image/voted-animation-gif.gif') }}" alt="" style="height: 550px">
                </div>
                <div class="mt-6 flex flex-col justify-center items-center">
                   <div class="flex justify-between items-center w-full">
                       <a href="{{ route('voter.download.receipt', $encodedVote->id) }}"
                          class="text-white text-[12px] px-4 py-2 mb-4 rounded w-[220px] bg-gray-500  hover:bg-black flex items-center justify-center">
                           Download Image Receipt
                       </a>
                       @php
                           $election = session('selectedElection') ? \App\Models\Election::find(session('selectedElection')) : null;
                       @endphp
                       @if (!session('Admin-Voting-Access'))
                       <a href="{{ route('voter.election.redirect')}}"
                          class="text-white text-[12px] px-4 py-2 mb-4 rounded w-[220px] bg-green-700 hover:bg-green-500 flex items-center justify-center">
                           Okay
                       </a>
                       @else
                           <a href="{{ route('dashboard', ['slug' => $election->slug]) }}"
                              class="text-white text-[12px] px-4 py-2 mb-4 rounded w-[220px] bg-green-700 hover:bg-green-500 flex items-center justify-center">
                               Okay
                           </a>
                       @endif
                   </div>
                    <div>
                        <a href="{{ route('verify.vote.page', ['voteId' => $encodedVote->id]) }}"
                           class="text-red-700 hover:underline text-[12px]">
                            Verify Your Vote
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </x-slot>
</x-app-layout>
