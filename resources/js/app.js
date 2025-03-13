import './bootstrap';
import "./packages/simple-notify";
import AOS from 'aos';
import 'aos/dist/aos.css';
import '@pqina/flip/dist/flip.css'
import '@pqina/flip/dist/flip.js';
import Tick from '@pqina/flip';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
Chart.register(ChartDataLabels);
window.Chart = Chart;



window.Tick = Tick;
AOS.init();

// Reusable function to initialize a chart
function initChart(canvasId, eventName) {
    const ctx = document.getElementById(canvasId).getContext('2d');

    // Initialize the chart with empty data
    const chart = new Chart(ctx, {
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
                    ticks: { color: 'black' },
                    grid: { color: 'rgba(0, 0, 0, 0.1)' }
                },
                x: {
                    ticks: { color: 'black' },
                    grid: { color: 'rgba(0, 0, 0, 0.1)' }
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
                legend: { display: false },
                datalabels: {
                    display: true,
                    align: 'end',
                    anchor: 'end',
                    formatter: (value, context) => {
                        if (value === 0) return null;
                        return `${context.dataset.label}: ${value} votes`;
                    },
                    color: 'black',
                    font: { weight: 'bold' }
                }
            }
        }
    });

    // Listen for Livewire events to update the chart
    Livewire.on(eventName, chartData => {
        console.log(`🔥 Raw Chart Data Received for ${canvasId}:`, chartData);

        if (Array.isArray(chartData) && chartData.length > 0) {
            chartData = chartData[0];
        }

        console.log(`📌 Extracted Chart Data for ${canvasId}:`, chartData);

        if (!chartData || !chartData.labels || !chartData.datasets) {
            console.error(`❌ Invalid chart data received for ${canvasId}!`);
            return;
        }

        if (!chartData.labels.length || !chartData.datasets.length) {
            console.warn(`⚠️ No valid data to display for ${canvasId}!`);
            return;
        }

        // ✅ Assign totalVoters safely
        let totalVoters = chartData.totalVoters ?? 100; // Default to 100 if undefined

        // Update chart data
        chart.data.labels = chartData.labels;
        chart.data.datasets = chartData.datasets;

        // ✅ Update y-axis max dynamically
        chart.options.scales.y.max = totalVoters;
        chart.options.scales.y.ticks.stepSize = Math.ceil(totalVoters / 10);

        chart.update();

        console.log(`✅ Chart Updated Successfully for ${canvasId} with totalVoters:`, totalVoters);
    });

    return chart;
}

// Export the function for reuse
window.initChart = initChart;


