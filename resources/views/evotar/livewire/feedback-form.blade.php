<div>
    <form wire:submit.prevent="submit" class="space-y-4 w-full">
        @if (session()->has('success'))
            <div class="text-green-600 text-sm">{{ session('success') }}</div>
        @elseif (session()->has('error'))
            <div class="text-red-600 text-sm">{{ session('error') }}</div>
        @endif

            <div>
                <label for="token" class="block text-gray-700 text-xs text-left">Token Code:</label>
                <input type="text" id="token" wire:model.defer="token" class="w-full px-4 py-2 border border-gray-300 rounded-md text-xs">
                @error('token') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
            <label class="block text-gray-700 text-xs text-left">Name or Nickname (Optional)</label>
            <input type="text" wire:model.defer="name" class="w-full px-4 py-2 border border-gray-300 rounded-md text-xs">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 text-xs text-left">Email (Optional)</label>
            <input type="text" wire:model.defer="email" class="w-full px-4 py-2 border border-gray-300 rounded-md text-xs">
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 text-xs text-left">Rate Your Experience</label>
            <div class="flex space-x-2">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="$set('rating', {{ $i }})"
                            class="text-4xl {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}">
                        &#9733;
                    </button>
                @endfor
            </div>
            @error('rating') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 text-xs text-left">Feedback</label>
            <textarea wire:model.defer="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md text-xs"></textarea>
            @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="w-full px-4 py-2 bg-black text-white rounded-md text-xs">
                Submit
            </button>
        </div>
    </form>

</div>
