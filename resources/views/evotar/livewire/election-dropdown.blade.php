<div class="absolute top-0 right-0 mt-4 mr-4 w-[450px]"> <!-- Responsive width -->
    <label class="block text-sm font-medium text-white" for="election-filter">Select Election</label>
    <select name="selectedElection" id="selectedElection"
            class="border-gray-300 text-xs rounded-lg px-4 py-2 w-full"
            wire:model.live="selectedElection">
        <option value="" selected disabled>Select an election</option>
        @foreach($elections as $election)
            <option value="{{ $election->id }}" {{ $election->id == $selectedElection ? 'selected' : '' }}>
                {{ $election->name }} - {{ $election->campus->name }}
            </option>
        @endforeach
    </select>
    @error('selectedElection')
    <span class="text-red-500 text-[10px] italic">{{ $message }}</span>
    @enderror
</div>
