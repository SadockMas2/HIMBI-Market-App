import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY || document.querySelector('meta[name="pusher-key"]').content,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER || document.querySelector('meta[name="pusher-cluster"]').content,
    forceTLS: true
});
