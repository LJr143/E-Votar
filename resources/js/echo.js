import Echo from 'laravel-echo';

// No need for Pusher import!
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
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME || 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
    },
});

// Debugging Reverb connection
window.Echo.connector.reverb.on('connected', () => {
    console.log('Reverb connected successfully!');
});

window.Echo.connector.reverb.on('error', (error) => {
    console.error('Reverb connection error:', error);
});
