import './bootstrap';
import "./packages/simple-notify";
import AOS from 'aos';
import 'aos/dist/aos.css';
import '@pqina/flip/dist/flip.css'
import '@pqina/flip/dist/flip.js';
import Tick from '@pqina/flip';

// Assign Tick to the global window object
window.Tick = Tick;

// Initialize AOS
AOS.init();


