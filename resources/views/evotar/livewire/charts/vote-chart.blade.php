<div>
    <canvas id="myChart" class="w-full h-full"></canvas>

    <script>
        function initChart() {
            const ctx = document.getElementById('myChart').getContext('2d');

            // Register the Chart.js datalabels plugin
            Chart.register(ChartDataLabels);

            // Initialize the chart with empty data
            let myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {color: 'black'},
                            grid: {color: 'rgba(0, 0, 0, 0.1)'}
                        },
                        x: {
                            ticks: {color: 'black'},
                            grid: {color: 'rgba(0, 0, 0, 0.1)'}
                        }
                    },
                    plugins: {
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: 'black',
                            bodyColor: 'black',
                            borderColor: 'rgba(0, 0, 0, 0.1)',
                            borderWidth: 1
                        },
                        legend: {display: false},
                        datalabels: {
                            display: true,
                            align: 'end',
                            anchor: 'end',
                            formatter: (value, context) => {
                                if (value === 0) return null;
                                return `${context.dataset.label}: ${value} votes`;
                            },
                            color: 'black',
                            font: {weight: 'bold'}
                        }
                    }
                }
            });

            // Listen for Livewire events to update the chart
            Livewire.on('chartUpdated', chartData => {
                console.log("🔥 Raw Chart Data Received:", chartData);

                if (Array.isArray(chartData) && chartData.length > 0) {
                    chartData = chartData[0];
                }

                console.log("📌 Extracted Chart Data:", chartData);

                if (!chartData || !chartData.labels || !chartData.datasets) {
                    console.error("❌ Invalid chart data received!");
                    return;
                }

                if (!chartData.labels.length || !chartData.datasets.length) {
                    console.warn("⚠️ No valid data to display!");
                    return;
                }

                // ✅ Assign totalVoters safely
                let totalVoters = chartData.totalVoters ?? 100; // Default to 100 if undefined

                // Update chart data
                myChart.data.labels = chartData.labels;
                myChart.data.datasets = chartData.datasets;

                // ✅ Update y-axis max dynamically
                myChart.options.scales.y.max = totalVoters;
                myChart.options.scales.y.ticks.stepSize = Math.ceil(totalVoters / 10);

                myChart.update();

                console.log("✅ Chart Updated Successfully with totalVoters:", totalVoters);
            });


            return myChart;
        }

        document.addEventListener("DOMContentLoaded", () => {
            let myChart = initChart();

            Livewire.hook('message.processed', () => {
                myChart.destroy();
                myChart = initChart();
            });
        });
    </script>
</div>
