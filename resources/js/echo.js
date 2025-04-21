import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: parseInt(import.meta.env.VITE_REVERB_PORT) || (window.location.protocol === 'https:' ? 443 : 80),
    wssPort: 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME === 'https'),
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'X-Requested-With': 'XMLHttpRequest'
        },
    },
    cluster: import.meta.env.VITE_REVERB_CLUSTER || 'mt1',
    activityTimeout: 60000, // 60 seconds
    pongTimeout: 30000, // 30 seconds
});


window.Echo.connector.pusher.connection.bind('state_change', (states) => {
    console.log('Connection state changed:', states.current);
});

console.log('Echo initialized with config:', {
    key: import.meta.env.VITE_REVERB_APP_KEY,
    host: window.location.hostname,
    port: import.meta.env.VITE_REVERB_PORT,
    scheme: import.meta.env.VITE_REVERB_SCHEME
});
