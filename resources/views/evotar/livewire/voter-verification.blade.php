<div>
    @if($voter->isVerifiedForCurrentYear())
        <div class="alert alert-success">
            ✅ You are verified for {{ now()->year }} elections.
        </div>
    @else
        <form wire:submit.prevent="submitVerification">
            <h3>Yearly Voter Verification</h3>

            <input type="file" wire:model="document" required>
            @error('document') <span class="error">{{ $message }}</span> @enderror

            <button type="submit" class="btn btn-primary">
                Submit Verification
            </button>

            @if($statusMessage)
                <div class="alert alert-info mt-3">
                    {{ $statusMessage }}
                </div>
            @endif
        </form>
    @endif
</div>
