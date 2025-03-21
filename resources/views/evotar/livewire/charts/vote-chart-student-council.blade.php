<div>
    <div class="bg-white p-4 mt-4 rounded-lg shadow-lg w-full ">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-black" style="font-size: 14px;">Tagum Student Council Election</h2>
        </div>
        <div class="flex justify-around mb-4">
            <div class="text-center">
                <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Voters</h4>
                <p class="text-lg text-black" style="font-size: 12px;">{{ $totalVoters }}</p>
            </div>
            <div class="border-l border-gray-300 mx-4"></div>
            <div class="text-center">
                <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Who Voted</h4>
                <p class="text-lg text-black" style="font-size: 12px;">{{ $totalVoterVoted }}</p>
            </div>
            <div class="border-l border-gray-300 mx-4"></div>
            <div class="text-center">
                <h4 class="text-lg font-semibold text-black" style="font-size: 14px;">Total Who Did Not
                    Vote</h4>
                <p class="text-lg text-black" style="font-size: 12px;">{{ $totalVoters - $totalVoterVoted }}</p>
            </div>
        </div>
        <div class="relative h-full">
            <canvas id="StudentCouncilChart" class="w-full h-full"></canvas>
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Initialize the Student Council Chart
            window.initChart('StudentCouncilChart', 'chartStudentCouncilUpdated');
        });
    </script>
</div>
