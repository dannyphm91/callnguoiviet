// Axios configuration
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Vue configuration
import Vue from 'vue/dist/vue.js';
import Messenger from '../components/Messenger.vue';

Vue.component("messenger", Messenger)

document.addEventListener('DOMContentLoaded', function() {
    const appElement = document.getElementById('app');

    if (appElement) {
        const app = new Vue({
            el: '#app'
            // Add other options as needed
        });
    }
});

// Pusher configuration
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
});

/**
 * Initialize the Echo instance and subscribe to channels
 */
var auth_check = $('#auth_user').val();

if (auth_check == 1) {
    window.Echo.private('chat')
        .listen('ChatMessage',(e)=>{
            var auth_user_id = $('#auth_user_id').val();

            if (e.chatMessage.to == auth_user_id) {
                playAudio();
                toastr.success('You have a new message', 'Success');
                loadUnreadMessageCount();
            }
        });
}
