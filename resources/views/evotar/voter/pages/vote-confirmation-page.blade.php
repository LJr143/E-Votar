<x-app-layout mainClass="flex" headerClass="" page_title="- Vote Confirmed">

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-evotar-components::voter.voter-header></x-evotar-components::voter.voter-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="min-h-screen w-full flex justify-center  " style="background-color: #E8EBEE">
           <div>
               <div>
                   <img src="{{ asset('storage/assets/image/voted-animation-gif.gif') }}" alt="" style="height: 550px">
               </div>
               <div class="flex justify-center items-center mt-6">
                   <button class="text-white text-[12px] px-4 py-2 mb-4 rounded w-[220px] bg-gray-500 flex items-center justify-center">Okay</button>
                   <a href="{{ route('verify.vote.page', ['voteId' => $encodedVote->id]) }}" class="text-blue-500 hover:underline">
                       Verify Your Vote
                   </a>
               </div>
           </div>

        </div>

    </x-slot>
</x-app-layout>
