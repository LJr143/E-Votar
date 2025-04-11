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


