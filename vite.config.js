import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: 'localhost', // Use 'localhost' instead of '0.0.0.0'
        cors: {
            origin: 'http://evotar.test', // Allow requests from this origin
        },
    },
});
