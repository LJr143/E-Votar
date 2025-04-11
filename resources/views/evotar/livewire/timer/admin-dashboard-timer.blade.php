<div>
    <div class="bg-black text-white p-4 rounded-lg shadow-md text-center min-h-[160px] ">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-stopwatch text-white text-sm"></i>
                <span class="text-sm font-bold text-white">Election Ends In:</span>
            </div>

            <div class="text-white">
                <i class="fas fa-pause-circle text-xl"></i>
                <i class="fas fa-stop-circle text-xl"></i>
            </div>
        </div>
        <div class="tick" data-did-init="handleTickInit" data-credits="false">
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
        </div>

    </div>

    <script>
        function handleTickInit(tick) {
            $.get("{{ url('/api/election-end-time/' . $selectedElection) }}", function (data) {
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
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
            });
        }
    </script>
</div>
