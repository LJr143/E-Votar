
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Reverb configuration for Echo
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8081,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});


// (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
window.Echo.channel('user-actions')
    .listen('UserActionUpdated', (data) => {
        console.log(`${data.user.id} was ${data.action}.`);

        if (data.action === 'added') {
            Livewire.dispatch('system-user-added');
        } else if (data.action === 'edited') {
            Livewire.dispatch('system-user_edited');
        } else if (data.action === 'deleted') {
            Livewire.dispatch('refreshTable');
        }
    });


