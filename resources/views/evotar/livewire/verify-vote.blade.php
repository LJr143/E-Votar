<div>
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Verify Your Vote</h2>

        @if ($error)
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ $error }}
            </div>
        @endif

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                Enter your voting password
            </label>
            <input type="password" id="password" wire:model="password" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button wire:click="verify" wire:loading.attr="disabled"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <span wire:loading.remove>Verify Vote</span>
            <span wire:loading wire:target="verify">
                Verifying...
            </span>
        </button>

        @if ($success)
            <div class="mt-8 border-t pt-6">
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ $success }}
                </div>

                <h3 class="text-lg font-semibold mb-4">Verification Results</h3>

                <div class="mb-4">
                    <h4 class="font-medium mb-2">Encrypted Data:</h4>
                    <div class="bg-gray-100 p-3 rounded overflow-x-auto">
                        <code class="text-sm">{{ $encryptedData }}</code>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="font-medium mb-2">Decrypted Vote Data:</h4>
                    <div class="bg-gray-100 p-3 rounded">
                        <pre class="text-sm">{{ json_encode($voteData, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
