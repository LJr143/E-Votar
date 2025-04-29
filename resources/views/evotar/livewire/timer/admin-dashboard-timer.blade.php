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

        <div id="custom-alert" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Election Countdown Ended!</h2>
                <p class="text-gray-600 mb-4">The election period has officially ended.</p>
                <button onclick="closeCustomAlert()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                    OK
                </button>
            </div>
        </div>

        <div id="stopped-alert" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Election Stopped</h2>
                <p class="text-gray-600 mb-4">The election has been stopped. The page will refresh soon.</p>
                <button onclick="closeStoppedAlert()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    OK
                </button>
            </div>
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
                    console.log('End time:', data.end_time);
                    if (data.end_time) {
                        var counter = Tick.count.down(data.end_time);
                        counter.onupdate = function (value) {
                            tick.value = value;
                        };
                        counter.onended = function () {
                            showCustomAlert();
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
                    showStoppedAlert();
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }
            });

        });

        function showStoppedAlert() {
            document.getElementById('stopped-alert').classList.remove('hidden');
        }

        function closeStoppedAlert() {
            document.getElementById('stopped-alert').classList.add('hidden');
            // Refresh the page after closing the alert
            setTimeout(function() {
                window.location.reload();
            }, 1000); // Adjust delay before refreshing if necessary
        }


        function showCustomAlert() {
            document.getElementById('custom-alert').classList.remove('hidden');
        }

        function closeCustomAlert() {
            document.getElementById('custom-alert').classList.add('hidden');
        }

    </script>
</div>
