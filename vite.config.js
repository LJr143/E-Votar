import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     host: '192.168.167.50',
    //     https: true
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css',  'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
