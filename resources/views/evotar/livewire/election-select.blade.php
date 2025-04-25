<div class="w-full">
    <div class="relative w-full bg-transparent lg:min-w-[450px] py-2 items-center cursor-pointer space-x-2">
        <div class="flex-1 w-full">
            <select name="selectedElection" id="selectedElection"
                    class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full"
                    wire:model.live="selectedElection">
                @if($elections && $selectedElection)
                    <option value="" selected disabled>Select an election</option>
                    @foreach($elections as $election)
                        <option value="{{ $election->id }}" {{ $election->id == $selectedElection ? 'selected' : '' }}>
                            {{ $election->name }} - {{ $election->campus->name }} - {{ $election->election_type->name }}
                        </option>
                    @endforeach
                @else
                    <option value="" selected>No Election Created Yet - Contact Your Superadmin</option>
                @endif
            </select>
            @error('selectedElection')
            <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
