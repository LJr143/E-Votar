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




