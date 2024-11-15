import './bootstrap';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


Pusher.logToConsole = true;
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
   // forceTLS: true
});


window.Echo.channel('stock-updates')

    .listen('.product.threshold.reached', (data) => {
        console.log(`Stock for ${data.product.name} is low!`, data);

        Swal.fire({
            title: 'Stock checking',
            text: `Stock for ${data.product.name} is low!`,
            icon: 'error',
        })
    });

