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
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
    },
});

// Debugging connection
window.Echo.connector.socket.on('connect', () => {
    console.log('Connected to Reverb server');
});

window.Echo.connector.socket.on('disconnect', () => {
    console.warn('Disconnected from Reverb server');
});

window.Echo.connector.socket.on('error', (error) => {
    console.error('WebSocket error:', error);
});
