<div>
    <div class="bg-black text-white rounded-lg shadow-md text-center min-h-[140px] lg:min-h-[170px] w-full">
        <div class="flex justify-between items-center mb-3 px-4 pt-4">
            <div class="flex items-center space-x-2">
                <i class="fas fa-stopwatch text-white text-sm"></i>
                <span class="text-sm font-bold text-white">Election Ends In:</span>
            </div>

            @if(auth()->user()->hasRole('superadmin'))
                <div class="text-white space-x-1">
                    @if(!$isStopped && $election->status != 'completed')
                        @if($isPaused)
                            <button wire:click="resumeElection" wire:key="election-resume-{{$election->id}}" class="text-green-400 hover:text-green-300">
                                <i class="fas fa-play-circle text-xl"></i>
                            </button>
                        @elseif(!$isStopped && $election->status != 'completed')
                            <button wire:click="pauseElection" wire:key="election-pause-{{$election->id}}" class="text-yellow-400 hover:text-yellow-300">
                                <i class="fas fa-pause-circle text-xl"></i>
                            </button>
                        @endif
                    @endif
                    @if($election->status != 'completed')
                        <button wire:click="stopElection" wire:key="election-stop-{{$election->id}}" class="text-red-400 hover:text-red-300">
                            <i class="fas fa-stop-circle text-xl"></i>
                        </button>
                    @endif
                </div>
            @endif
        </div>

        <div wire:ignore class="tick" data-did-init="handleTickInit" data-credits="false">
            @if($election->status == 'completed')
                <div class="tick-onended-message text-white">
                    <p>ELECTION HAS ENDED</p>
                </div>
            @else
                <div
                    data-repeat="true"
                    data-layout="horizontal fit"
                    data-transform="preset(d, h, m, s) -> delay"
                    class="tick-container">

                    <div class="tick-group">
                        <div data-key="value" data-repeat="true" data-transform="pad(00) -> split -> delay">
                            <span data-view="flip" class="tick-value"></span>
                        </div>
                        <span data-key="label" data-view="text" class="tick-label"></span>
                    </div>
                </div>
                <div class="tick-onended-message" style="display: none">
                    <p>Time's up</p>
                </div>
            @endif

        </div>

    </div>
    <script>
        console.log('window.Tick before fetch:', window.Tick);
        function handleTickInit(tick) {
            fetch("{{ route('election.end.time', ['electionId' => $selectedElection]) }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch election data');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('End time:', data.end_time); // Confirm this logs correctly
                    if (data.end_time) {
                        var counter = Tick.count.down(data.end_time);
                        counter.onupdate = function (value) {
                            tick.value = value;
                        };
                        counter.onended = function () {
                            alert('Election countdown ended!');
                        };
                    } else {
                        console.error('No end time found');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('timer-stopped', (data) => {
                if (data.shouldRefresh) {
                    // Show a message before refreshing
                    alert('Election has been stopped. The page will refresh.');

                    // Refresh the page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
        });
    </script>
</div>
