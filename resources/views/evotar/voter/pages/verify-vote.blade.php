<x-app-layout mainClass="flex" headerClass="" page_title="- Verify Vote">
    <x-slot name="header">
        <div class="px-6 w-full">
            <x-evotar-components::voter.voter-header />
        </div>
    </x-slot>

    <x-slot name="main">
        <div class="min-h-screen w-full flex justify-center bg-[#E8EBEE] px-4 py-10">
            <div class="max-w-xl w-full bg-white p-6 rounded-lg shadow-lg">

                <!-- Title -->
                <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">🗳️ Verify Your Vote</h1>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                <!-- Upload Form -->
                <form action="{{ route('verify.vote.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- File Input -->
                    <div>
                        <label for="vote_image" class="block text-sm font-medium text-gray-700 mb-1">
                            Upload Encoded Vote Image
                        </label>
                        <input
                            type="file"
                            name="vote_image"
                            id="vote_image"
                            accept="image/png,image/jpeg"
                            required
                            class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-red-500 focus:border-red-500"
                        >
                        <p class="text-xs text-gray-500 mt-1">Upload the image you downloaded after casting your vote (PNG or JPEG).</p>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button
                            type="submit"
                            class="w-full bg-red-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-red-700 transition"
                        >
                            🔍 Verify Vote
                        </button>
                    </div>
                </form>

                <!-- Encrypted Data (Optional Display) -->
                @if (session('encryptedData'))
                    <div class="mt-8">
                        <h2 class="text-lg font-semibold mb-2 text-gray-700">🔐 Encrypted Data</h2>
                        <div class="bg-gray-100 p-4 rounded text-sm overflow-x-auto">
                            <pre>{{ session('encryptedData') }}</pre>
                        </div>
                    </div>
                @endif

                <!-- Decrypted Vote Data -->
                @if (session('voteData'))
                    <div class="mt-8">
                        <h2 class="text-lg font-semibold mb-2 text-gray-700">📖 Decrypted Vote Details</h2>

                        @php
                            $voteData = session('voteData');
                        @endphp

                        <div class="bg-gray-100 rounded p-4 mb-4 text-sm space-y-1">
                            <p><strong>Voter Name:</strong> {{ $voteData['voter_name'] ?? 'N/A' }}</p>
                            <p><strong>Program:</strong> {{ $voteData['voter_program'] ?? 'N/A' }}</p>
                            <p><strong>Major:</strong> {{ $voteData['voter_major'] ?? 'N/A' }}</p>
                            <p><strong>Election:</strong> {{ $voteData['election_name'] ?? 'N/A' }}</p>
                            <p><strong>Timestamp:</strong> {{ $voteData['timestamp'] ?? 'N/A' }}</p>
                        </div>

                        <!-- Votes Table -->
                        <div class="overflow-x-auto mt-4">
                            <table class="w-full table-auto border border-gray-300 text-sm">
                                <thead class="bg-black text-white">
                                <tr>
                                    <th class="px-2 py-2 border">Position</th>
                                    <th class="px-2 py-2 border">Candidate</th>
                                    <th class="px-2 py-2 border">Party List</th>
                                    <th class="px-2 py-2 border">Program</th>
                                    <th class="px-2 py-2 border">Major</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($voteData['votes'] ?? [] as $vote)
                                    <tr class="border-t text-white">
                                        <td class="px-2 py-2 border">{{ $vote['position_name'] ?? '—' }}</td>
                                        <td class="px-2 py-2 border">{{ $vote['candidate_name'] ?? '—' }}</td>
                                        <td class="px-2 py-2 border">{{ $vote['party_list'] ?? 'Independent' }}</td>
                                        <td class="px-2 py-2 border">{{ $vote['program'] ?? '—' }}</td>
                                        <td class="px-2 py-2 border">{{ $vote['major'] ?? '—' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Abstentions -->
                        @if (!empty($voteData['abstentions']))
                            <div class="mt-4">
                                <h3 class="text-md font-semibold text-gray-700 mb-1">🚫 Abstained Positions:</h3>
                                <ul class="list-disc list-inside text-gray-600 text-sm">
                                    @foreach ($voteData['abstentions'] as $abstain)
                                        <li>{{ $abstain['position_name'] ?? 'Unknown Position' }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-app-layout>
