<x-custom-layout>
    <x-slot name="wheader">
        <x-wheader /> <!-- Use the header component -->
    </x-slot>

    <x-slot name="main">
        <main>
            <div class="relative">
                <img alt="Eagle" class="w-full h-full object-cover" src="{{ asset('storage/assets/image/eaglee.png') }}"  />
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-50">
                    <h1 class="text-4xl font-bold text-white">
                      Policies
                    </h1>
                    <nav class="mt-2">
                        <a class="text-white text-xs" href="#">
                            Home
                        </a>
                        <span class="mx-2 text-xs text-white">
                          &gt;
                         </span>
                        <a class="text-white text-xs" href="#">
                            Feedback
                        </a>
                    </nav>
                </div>
            </div>
            <div class="py-12 ">
                <div class="container mx-auto text-justify px-10">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-center mb-10 text-black">
                    POLICIES FOR TAGUM STUDENT AND LOCAL COUNCIL ELECTIONS
                    </h2>
                    <p class="text-black font-semibold text-sm mb-4">
                        1. General Provisions
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        1.1. These policies govern the conduct of online elections for the University of
                        Southeastern Philippines Tagum Student Council (USeP-TSC).
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        1.2. The online voting system shall be implemented to ensure a fair, transparent, and
                        secure electoral process.
                    </p>
                    <p class="text-gray-600 text-sm  ml-3 mb-4">
                        1.3. All candidates, campaigners, and voters must adhere to these policies, along with
                        the Election Code and other applicable university regulations.
                    </p>
                    <p class="text-black font-semibold text-sm mb-4">
                        2. Voter Eligibility and Access
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        2.1. Only officially registered students of USeP-Tagum Campus with verified student
                        credentials are eligible to vote.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        2.2. Voter access credentials shall be unique and confidential. Any unauthorized
                        sharing or misuse will be subject to penalties.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        2.3. The online voting system will be accessible only during the designated voting
                        period, as determined by the USeP-TSC ComElec.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-4">
                        2.4. Any technical difficulties affecting the voting process must be reported
                        immediately to the ComElec for resolution.
                    </p>

                    <p class="text-black font-semibold text-sm mb-4">
                        3. Candidate and Campaign Regulations
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        3.1. Candidates must submit all required documents, including the Certificate of
                        Candidacy (COC), by the deadline set by ComElec.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        3.2. Campaign activities must strictly follow the approved campaign period. Early or
                        post-campaigning is prohibited.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        3.3. The use of digital platforms for campaigning is allowed, provided that no
                        misinformation, hate speech, or personal attacks are disseminated.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        3.4. All campaign materials, whether physical or digital, must be pre-approved by
                        ComElec.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-4">
                        3.5. The online voting system prohibits candidates from interfering with or attempting
                        to manipulate the voting process.
                    </p>
                    <p class="text-black font-semibold text-sm mb-4">
                        4. Prohibited Acts
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        4.1. Vote-Buying and Vote-Selling: Any form of compensation, monetary or otherwise,
                        in exchange for votes is strictly prohibited.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        4.2. Intimidation or Coercion: Any form of harassment or coercion aimed at influencing
                        a voter's decision is not allowed.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        4.3. Multiple or Proxy Voting: Each voter is entitled to only one vote. Voting on behalf
                        of another person is strictly forbidden.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        4.4. Tampering with the Online Voting System: Any attempt to hack, manipulate, or
                        disrupt the online voting system will result in immediate disqualification and
                        potential disciplinary action.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-4">
                        4.5. Campaigning During the Election Period: Campaigning on election day or during
                        the designated campaign ban period is strictly prohibited.
                    </p>
                    <p class="text-black font-semibold text-sm mb-4">
                        5. Voting Procedures
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        5.1. The voting process shall be conducted through a secure online voting system.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        5.2. Voters must log in using their unique credentials to access the voting platform.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        5.3. Each voter shall be given a single opportunity to cast their vote. Once submitted,
                        votes cannot be altered or withdrawn.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        5.4. The secrecy and anonymity of votes must be maintained at all times.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-4">
                        5.5. Election results shall be published only after the official closing of the voting period
                        and upon verification by ComElec.
                    </p>
                    <p class="text-black font-semibold text-sm mb-4">
                        6. Post-Election and Dispute Resolution
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        6.1. Election results shall be validated and certified by the USeP-TSC ComElec before
                        official announcement.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        6.2. Any complaints or disputes regarding the election process must be submitted in
                        writing to ComElec within 24 hours after the conclusion of the voting period.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        6.3. The ComElec shall conduct a thorough review of complaints and provide a
                        resolution within a reasonable time frame.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-4">
                        6.4. Any proven violations of election policies may result in disqualification, disciplinary
                        action, or other appropriate sanctions.
                    </p>
                    <p class="text-black font-semibold text-sm mb-4">
                        7. Final Provisions
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        7.1. These policies take effect immediately upon approval and shall remain in force
                        unless amended by the USeP-TSC ComElec.
                    </p>
                    <p class="text-gray-600 text-sm ml-3 mb-2">
                        7.2. Any matters not covered in these policies shall be resolved based on the Election
                        Code, university regulations, and applicable laws.
                    </p>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-center mt-10 text-black">
                       Do's and Don'ts for Candidates and Campaigners
                    </h2>
                    <div class="flex flex-col md:flex-row gap-6 p-6 sm:p-8 md:p-10">
                        <!-- Do's Card -->
                        <div class="bg-white shadow-md rounded-lg p-4 sm:p-6 w-[105%] sm:w-[95%] md:w-2/3 lg:w-3/4 mx-auto">
                            <h2 class="text-lg sm:text-xl font-semibold text-green-600 mb-4">✅ Do’s for Candidates and Campaigners (Best Practices)</h2>
                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                1. Adhere to the Filing Requirements: Submit all necessary documents, including the
                                Certificate of Candidacy (COC), academic records, character certification, and
                                other required forms, by the deadlines specified by the USeP-TSC ComElec.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                2. Participate in the Pre-Election Orientation: Attend the pre-election orientation to
                                understand the election guidelines, procedures, and any updates provided by the
                                USeP-TSC ComElec.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                3. Engage in Positive Campaigning: Promote your platforms and ideas
                                constructively. Focus on what you can offer to the student body rather than
                                attacking your opponents.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                4. Respect Campaign Guidelines: Follow the specified campaign period and refrain
                                from early campaigning. Participate in the Miting de Avance and present your
                                platforms clearly and respectfully.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                5. Ensure Honest Communication: Provide accurate information about your
                                qualifications and plans. Maintain transparency in all your campaign activities.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                6. Follow Election Day Procedures: Encourage supporters to vote within the specified
                                voting period. Respect the secrecy and integrity of the online voting process.
                            </p>

                        </div>

                        <!-- Don'ts Card -->
                            <div class="bg-white shadow-md rounded-lg p-4 sm:p-6 w-[105%] sm:w-[95%] md:w-2/3 lg:w-3/4 mx-auto">
                                <h2 class="text-lg sm:text-xl font-semibold text-red-600 mb-4">❌ Don’ts for Candidates and Campaigners (Avoid These Mistakes)</h2>
                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                1. Avoid Vote-Buying and Vote-Selling: Do not offer or give money, gifts, or any form
                                of bribe to influence voters. Do not accept any form of compensation in exchange
                                for your vote.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                2. Do Not Engage in Intimidation or Coercion: Avoid using threats, force, or any form
                                of intimidation to influence the voting decisions of others.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                3. Refrain from Negative Campaigning: Do not engage in mudslinging, spreading
                                false information, or personal attacks against other candidates.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                4. Prohibit Unauthorized Campaign Materials: Do not use materials that are not
                                approved by the USeP-TSC ComElec. Avoid placing campaign materials in
                                restricted areas or on university property without proper authorization.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                5. Respect the Election Ban: Do not campaign or solicit votes during the designated
                                campaign ban periods as specified by the USeP-TSC ComElec.
                            </p>
                        </div>
                    </div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-center mt-10 text-black">
                        Do's and Don'ts for Voters
                    </h2>
                    <div class="flex flex-col md:flex-row gap-6 p-6 sm:p-8 md:p-10">
                        <!-- Do's Card -->
                        <div class="bg-white shadow-md rounded-lg p-4 sm:p-6 w-[105%] sm:w-[95%] md:w-2/3 lg:w-3/4 mx-auto">
                            <h2 class="text-lg sm:text-xl font-semibold text-green-600 mb-4">✅ Do’s for Voters (Best Practices)</h2>
                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                1. Stay Informed: Attend the Miting de Avance and other election-related events to
                                understand the platforms of all candidates.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                2. Vote Honestly: Cast your vote based on your informed judgment and preference
                                without external influence or coercion.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                3. Follow Voting Procedures: Vote within the designated online voting period and
                                ensure that your vote is confidential and properly submitted.
                            </p>

                        </div>

                        <!-- Don'ts Card -->
                            <div class="bg-white shadow-md rounded-lg p-4 sm:p-6 w-[105%] sm:w-[95%] md:w-2/3 lg:w-3/4 mx-auto">
                                <h2 class="text-lg sm:text-xl font-semibold text-red-600 mb-4">❌ Don’ts for Voters (Avoid These Mistakes)</h2>
                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                1. Stay Informed: Attend the Miting de Avance and other election-related events to
                                understand the platforms of all candidates.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                2. Vote Honestly: Cast your vote based on your informed judgment and preference
                                without external influence or coercion.
                            </p>

                            <p class="text-gray-600 text-sm ml-3 mb-2">
                                3. Follow Voting Procedures: Vote within the designated online voting period and
                                ensure that your vote is confidential and properly submitted.
                            </p>

                        </div>
                    </div>
                </div>
            </div>

        </main>
    </x-slot>

    <x-slot name="wfooter">
        <x-wfooter /> <!-- Use the footer component -->
    </x-slot>
</x-custom-layout>
