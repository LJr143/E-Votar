import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Register the plugin
Chart.register(ChartDataLabels);

// Function to create gradient
function createGradient(ctx, color1, color2) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    return gradient;
}

// Function to create bar charts
function createBarChart(ctxId, labels, data, color1, color2) {
    const ctx = document.getElementById(ctxId)?.getContext('2d');
    if (!ctx) return; // Prevent errors if element doesn't exist

    const gradient = createGradient(ctx, color1, color2);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Votes',
                data: data,
                backgroundColor: [gradient, gradient],
                borderColor: ['#000000', '#000000'],
                borderWidth: 1,
                borderRadius: 5,
                barThickness: 30,
                hoverBackgroundColor: ['#333333', '#CCCCCC'],
                hoverBorderColor: ['#333333', '#CCCCCC']
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true, grid: { display: false }, ticks: { color: '#000000' } },
                y: { grid: { display: false }, ticks: { color: '#000000' } }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#000000',
                    titleColor: '#FFFFFF',
                    bodyColor: '#FFFFFF',
                    borderColor: '#000000',
                    borderWidth: 1
                },
                datalabels: {
                    anchor: 'center',
                    align: 'center',
                    color: function(context) {
                        return context.dataset.backgroundColor[context.dataIndex] === '#FFFFFF' ? '#000000' : '#FFFFFF';
                    },
                    font: { weight: 'bold' },
                    formatter: function(value) { return value + ' votes'; }
                }
            }
        }
    });
}

// Create each chart
createBarChart('presidentChart', ['Hamisi Mtengti', 'Abstain'], [1500, 5], '#000000', '#FFFFFF');
createBarChart('internalVicePresidentChart', ['Henry Kasembe', 'Abstain'], [24, 3], '#000000', '#FFFFFF');
createBarChart('externalVicePresidentChart', ['Lisa Henry', 'Abstain'], [11, 7], '#000000', '#FFFFFF');

document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('myChart').getContext('2d');

    // Create gradient (optional)
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 0, 0, 1)');
    gradient.addColorStop(1, 'rgba(51, 51, 51, 1)');

    // Register the plugin
    Chart.register(ChartDataLabels);

    // Create the chart
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['President', 'Internal VP', 'External VP', 'General Secretary', 'General Treasurer', 'Senator'],
            datasets: [
                {
                    label: 'Candidate A',
                    data: [500, 900, 400, 800, 700, 1000],
                    backgroundColor: gradient,
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Abstain',
                    data: [600, 1000, 500, 900, 800, 1100],
                    backgroundColor: 'rgba(102, 102, 102, 1)',
                    borderColor: 'rgba(102, 102, 102, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 1200,
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
                    borderWidth: 1,
                    callbacks: {
                        title: (context) => context[0].label,
                        label: (context) => {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) label += context.parsed.y + ' votes';
                            return label;
                        }
                    }
                },
                legend: { display: false },
                datalabels: {
                    display: true,
                    align: 'end',
                    anchor: 'end',
                    formatter: (value, context) => `${context.dataset.label}: ${value} votes`,
                    color: 'black',
                    font: { weight: 'bold' }
                }
            }
        }
    });
});
