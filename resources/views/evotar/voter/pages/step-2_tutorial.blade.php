<x-app-layout mainClass="flex" headerClass="" page_title="- Dashboard">

    <x-slot name="header">
        <div class="px-6 w-full">
            <x-evotar-components::voter.voter-header></x-evotar-components::voter.voter-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="px-6 w-full">
            <div class="flex w-full min-h-full ">
                <div class="h-full w-1/2 overflow-x-auto mb-12">
                    <div class="mt-4 flex mb-10">
                        <a href=""
                           class="underline text-red-500 capitalize tracking-tight font-light italic text-[12px] ml-10">Proceed
                            to Comelec Website</a>
                    </div>
                    <p class="uppercase tracking-tighter font-bold text-[14px] italic" style="margin: 5px 0 0 75px">
                        Voting Made Easy!</p>
                    <div class="w-3/4">
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">Follow
                            these easy steps to vote!</p>
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">1.After
                            logging in you will be directed to the the Tagum Student Council Election Page for the phase
                            1 and clicking proceed to local council will take you to the local council election
                            page.</p>
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">2. You can
                            either select a candidate to vote or to abstain from a certain position.</p>
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">3. You can
                            vote 1 for each student council position and 1 for each local council position except for
                            the senator position you can select 3. Remember! You can either select or choose to
                            abstain. </p>
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">4. Click on
                            the <span class="font-semibold">see more</span> to see the candidates details including
                            his/her college, program, year level and motto.</p>
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">5. To
                            select just pick your candidate and make it the first to show!.</p>
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">6. After
                            carefully selecting, click submit button to see a summary of your vote.</p>
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">7. If all
                            your votes are correct, you can now click the confirm and you will be directed to the phase
                            2 of the voting process.</p>
                        <p class="text-[11px] font-light text-gray-700 italic" style="margin: 20px 0 0 90px">8.
                            Otherwise, you can always go back and correct your vote, just click the back button.</p>
                        <div class="flex justify-end mt-4">
                            <button onclick="window.location.href='{{ route('voter.voting', ['slug' => session('election_slug')]) }}';"
                                    class="text-[10px] uppercase text-gray-700 italic underline text-left">
                                Start Voting
                            </button>

                        </div>
                    </div>

                </div>
                <div class="w-1/2 min-h-full flex justify-center items-center"
                     style="background-image: url('{{ asset('storage/assets/image/voter-tutorial-bg-2.png') }}'); background-repeat: no-repeat; background-size: contain ">

                    <img src="{{ asset('storage/assets/image/tutorial-asset-img-3.png') }}" alt="asset-1"
                         style="width: 480px; margin-right: 80px">

                </div>
            </div>
            <div class="mt-auto flex justify-between text-[11px] italic mb-2 font-light px-10"
                 style="margin-top: 70px">
                <div class="flex space-x-2">
                    <p>Copyright@2025</p>
                    <a href="" class="underline text-blue-500">Feedback we want to hear from you!</a>
                </div>
                <div>

                </div>
                <div>
                    <p>E-Votar@2025</p>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
