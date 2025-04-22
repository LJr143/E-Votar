import Echo from 'laravel-echo';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

if (!csrfToken) {
    console.warn('CSRF token not found - WebSocket authentication may fail');
}

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    scheme: import.meta.env.VITE_REVERB_SCHEME ?? 'https',
    encrypted: true,
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
    },
});

// Debugging Reverb connection status
window.Echo.connector.reverb.connection.bind('state_change', (states) => {
    console.log('Reverb connection state:', states.current);
});

window.Echo.connector.reverb.connection.bind('error', (error) => {
    console.error('Reverb WebSocket error:', error);
});
