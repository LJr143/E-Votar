<x-app-layout mainClass="flex" headerClass="" page_title="- Verify Vote">
    <x-slot name="header">
        <div class="px-6 w-full">
            <x-evotar-components::voter.voter-header></x-evotar-components::voter.voter-header>
        </div>
    </x-slot>
    <x-slot name="main">
        <div class="min-h-screen w-full flex justify-center" style="background-color: #E8EBEE">
            <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md mt-10">
                <h1 class="text-2xl font-bold mb-4">Verify Your Vote</h1>

                <!-- Display success/error messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Upload Form -->
                <form action="{{ route('verify.vote.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- File Input -->
                    <div class="mb-4">
                        <label for="vote_image" class="block text-sm font-medium text-gray-700">
                            Upload Encoded Vote Image
                        </label>
                        <input
                            type="file"
                            name="vote_image"
                            id="vote_image"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            accept="image/png,image/jpeg"
                            required
                        >
                        <p class="mt-2 text-sm text-gray-500">
                            Upload the PNG or JPEG image you downloaded after voting.
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        >
                            Verify Vote
                        </button>
                    </div>
                </form>

                <!-- Display Encrypted Data -->
                @if (session('encryptedData'))
                    <div class="mt-6 overflow-x-auto">
                        <h2 class="text-xl font-semibold mb-2">Encrypted Data</h2>
                        <pre class="bg-gray-200 p-4 rounded">{{ session('encryptedData') }}</pre>
                    </div>
                @endif

                <!-- Display Decrypted Vote Data -->
                @if (session('voteData'))
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold mb-2">Decrypted Vote Data</h2>
                        <pre class="bg-gray-200 p-4 rounded">{{ json_encode(session('voteData'), JSON_PRETTY_PRINT) }}</pre>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-app-layout>
