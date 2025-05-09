<div>
    <div class="bg-white p-4 md:p-8 rounded-lg shadow-md w-full max-w-4xl mx-auto">
        <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6 text-center">Verify Your Vote</h2>

        @if ($error)
            <div class="mb-4 p-3 md:p-4 bg-red-100 text-red-700 rounded text-sm md:text-base">
                {{ $error }}
            </div>
        @endif

        @if (!$success)
            <div class="mb-4">
                <label for="password" class="block text-sm md:text-base font-medium text-gray-700 mb-1">
                    Enter your voting password
                </label>
                <input type="password" id="password" wire:model="password" required
                       class="w-full px-3 py-2 text-sm md:text-base border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button wire:click="verify" wire:loading.attr="disabled"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm md:text-base">
                <span wire:loading.remove>Verify Vote</span>
                <span wire:loading wire:target="verify">
                    Verifying...
                </span>
            </button>
        @endif

        @if ($success)
            <div class="mt-4 md:mt-6 p-3 md:p-4 bg-green-100 text-green-700 rounded text-sm md:text-base">
                {{ $success }}
            </div>

            <div class="mt-6 md:mt-8">
                <h2 class="text-base md:text-lg font-semibold mb-2 text-gray-700">📖 Decrypted Vote Details</h2>

                <div class="bg-gray-100 rounded p-3 md:p-4 mb-4 text-xs md:text-sm space-y-1">
                    <p><strong>Voter Name:</strong> {{ $voteData['voter_name'] ?? 'N/A' }}</p>
                    <p><strong>Program:</strong> {{ $voteData['voter_program'] ?? 'N/A' }}</p>
                    <p><strong>Major:</strong> {{ $voteData['voter_major'] ?? 'N/A' }}</p>
                    <p><strong>Election:</strong> {{ $voteData['election_name'] ?? 'N/A' }}</p>
                    <p><strong>Timestamp:</strong> {{ $voteData['timestamp'] ?? 'N/A' }}</p>
                </div>

                <!-- Votes Table - Responsive with horizontal scroll on small screens -->
                <div class="mt-4 overflow-x-auto">
                    <div class="min-w-[600px] md:w-full"> <!-- Force minimum width on small screens -->
                        <table class="w-full table-auto border border-gray-300 text-xs md:text-sm">
                            <thead class="bg-black text-white">
                            <tr>
                                <th class="px-2 py-2 border whitespace-nowrap">Position</th>
                                <th class="px-2 py-2 border whitespace-nowrap">Candidate</th>
                                <th class="px-2 py-2 border whitespace-nowrap">Party List</th>
                                <th class="px-2 py-2 border whitespace-nowrap">Program</th>
                                <th class="px-2 py-2 border whitespace-nowrap">Major</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($voteData['votes'] ?? [] as $vote)
                                <tr class="border-t text-black">
                                    <td class="px-2 py-2 border whitespace-nowrap">{{ $vote['position_name'] ?? '—' }}</td>
                                    <td class="px-2 py-2 border whitespace-nowrap">{{ $vote['candidate_name'] ?? '—' }}</td>
                                    <td class="px-2 py-2 border whitespace-nowrap">{{ $vote['party_list'] ?? 'Independent' }}</td>
                                    <td class="px-2 py-2 border whitespace-nowrap">{{ $vote['program'] ?? '—' }}</td>
                                    <td class="px-2 py-2 border whitespace-nowrap">{{ $vote['major'] ?? '—' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Abstentions -->
                @if (!empty($voteData['abstentions']))
                    <div class="mt-3 md:mt-4">
                        <h3 class="text-sm md:text-md font-semibold text-gray-700 mb-1">🚫 Abstained Positions:</h3>
                        <ul class="list-disc list-inside text-gray-600 text-xs md:text-sm">
                            @foreach ($voteData['abstentions'] as $abstain)
                                <li class="whitespace-nowrap">{{ $abstain['position_name'] ?? 'Unknown Position' }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Encrypted Data (Optional) -->
                <div class="mt-4 md:mt-6 border-t pt-3 md:pt-4">
                    <h3 class="text-sm md:text-md font-semibold text-gray-700 mb-2">🔒 Encrypted Data:</h3>
                    <div class="bg-gray-100 p-2 md:p-3 rounded overflow-x-auto">
                        <code class="text-xs">{{ $encryptedData }}</code>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>s
