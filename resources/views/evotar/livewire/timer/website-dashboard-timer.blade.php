<div>
    <style>
        .custom-countdown {
            background: transparent !important;
            padding: 0 !important;
            max-height: 90px !important;
        }

        .custom-countdown .tick-container {
            display: flex !important;
            gap: 4rem !important;
            justify-content: center !important;
        }

        .custom-countdown .tick-group {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }

        .custom-countdown .tick-value {
            font-size: 1.5rem !important;
            font-weight: bold !important;
            color: #000000 !important;
            padding: 0 !important;
            text-align: center !important;
            background: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        .custom-countdown .timer-header {
            display: flex !important;
            margin-bottom: 0.6rem !important;
            color: black;
            font-size: 0.6rem; !important;
        }

        .custom-countdown .tick-label {
            font-size: 0.75rem !important;
            color: #000000 !important;
            margin-top: 0.5rem !important;
            text-transform: uppercase !important;
        }

        .custom-countdown .times-up {
            font-size: 1.25rem !important;
            color: #ff0000 !important;
            font-weight: bold !important;
            text-align: center !important;
            padding: 1rem !important;
            display: none !important;
        }
    </style>

    @php
        use Carbon\Carbon;
        $election = \App\Models\Election::find($selectedElection);
    @endphp

    @if(!$election)
        <div class="text-red-500">
            Election not found
        </div>
    @elseif(Carbon::parse($election->date_started)->isFuture())
        <div>
            <h2 class="text-[12px] sm:text-xl font-semibold mb-1">Election Has Not Yet Started</h2>
            <p class="text-sm sm:text-base text-gray-300 text-center">
                Voting will begin on {{ Carbon::parse($election->date_started)->isoFormat('MMMM D, YYYY') }}<br>
                ({{ Carbon::parse($election->date_started)->diffForHumans() }})
            </p>
        </div>
    @elseif(Carbon::parse($election->date_ended)->isPast())
        <div>
            <h2 class="text-[12px] text-center sm:text-xl font-semibold mb-1">Election Has Ended</h2>
            <p class="text-sm sm:text-base text-gray-300 text-center">
                Voting ended on {{ Carbon::parse($election->date_ended)->isoFormat('MMMM D, YYYY') }}
            </p>
        </div>
    @else
        <div class="custom-countdown" wire:ignore>
            <div class="timer-header flex justify-center text-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-stopwatch text-black"></i>
                    <span class="text-sm font-bold">Election has Ended</span>
                </div>
            </div>
            <div id="countdown-display">
                <div class="tick-container">
                    <div class="tick-group">
                        <div class="tick-value" id="days">00</div>
                        <span class="tick-label">Days</span>
                    </div>
                    <div class="tick-group">
                        <div class="tick-value" id="hours">00</div>
                        <span class="tick-label">Hours</span>
                    </div>
                    <div class="tick-group">
                        <div class="tick-value" id="minutes">00</div>
                        <span class="tick-label">Minutes</span>
                    </div>
                    <div class="tick-group">
                        <div class="tick-value" id="seconds">00</div>
                        <span class="tick-label">Seconds</span>
                    </div>
                </div>
            </div>

            <div class="times-up" id="times-up-message">
                Time's up! Election has ended.
            </div>
        </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let countdownInterval;
            let endTime;
            let isPaused = false;

            // Initialize countdown
            initCountdown();

            function initCountdown() {
                fetch("{{ route('election.end.time', ['electionId' => $selectedElection]) }}")
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch election data');
                        return response.json();
                    })
                    .then(data => {
                        if (data.end_time) {
                            endTime = new Date(data.end_time);
                            updateCountdown();
                            countdownInterval = setInterval(updateCountdown, 1000);
                        } else {
                            console.error('No end time found');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error.message);
                    });
            }

            function updateCountdown() {
                if (isPaused) return;

                const now = new Date();
                const diff = endTime - now;

                if (diff <= 0) {
                    clearInterval(countdownInterval);
                    // Update all values to 00
                    document.getElementById('days').textContent = '00';
                    document.getElementById('hours').textContent = '00';
                    document.getElementById('minutes').textContent = '00';
                    document.getElementById('seconds').textContent = '00';

                    // Show times up message
                    document.getElementById('times-up-message').style.display = 'block';
                    return;
                }

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById('days').textContent = days.toString().padStart(2, '0');
                document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
            }
        });
    </script>
</div>
