import './bootstrap';
import "./packages/simple-notify";
import AOS from 'aos';
import 'aos/dist/aos.css';
import '@pqina/flip/dist/flip.css'
import '@pqina/flip/dist/flip.js';
import Tick from '@pqina/flip';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';


// Import styles
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';


FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize,
    FilePondPluginImageEdit
);

Chart.register(ChartDataLabels);



window.Chart = Chart;
window.FilePond = FilePond;
window.Tick = Tick;
AOS.init();

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


import Swiper from 'swiper';
import 'swiper/css';

window.Swiper = Swiper;

document.addEventListener('DOMContentLoaded', () => {
    new Swiper('#studentCouncil', {
        slidesPerView: 1,
        spaceBetween: 16,
        grabCursor: true,
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        breakpoints: {
            640: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        },
    });

    new Swiper('#localCouncil', {
        slidesPerView: 1,
        spaceBetween: 16,
        grabCursor: true,
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        breakpoints: {
            640: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        },
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const swipers = document.querySelectorAll('.swiper-container');

    swipers.forEach(swiperContainer => {
        new Swiper(swiperContainer, {
            slidesPerView: 1,
            spaceBetween: 16,
            grabCursor: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    });
});


