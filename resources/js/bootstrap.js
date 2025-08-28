import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,  // ou process.env.MIX_PUSHER_APP_KEY selon ta config
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// Écouter le canal public "commandes"
Echo.channel('commandes')
    .listen('.commande.confirmee', (e) => {
        console.log('Commande reçue:', e);

        // Jouer le son
        let audio = document.getElementById('notifSound');
        if(audio) audio.play().catch(err => console.log(err));

        // Mettre à jour le badge
        let badge = document.getElementById('notifBadge');
        badge.innerText = parseInt(badge.innerText) + 1;

        // Ajouter le spam dans la sidebar
        const sidebar = document.getElementById('sidebarNotifications');
        if(sidebar){
            const div = document.createElement('div');
            div.className = 'alert alert-info';
            div.style.background = '#34495e';
            div.style.color = '#fff';
            div.style.padding = '8px';
            div.style.marginBottom = '5px';
            div.style.borderRadius = '6px';

            let plats = e.commande.map(c => `${c.title} x ${c.quantity}`).join(', ');
            div.innerHTML = `<strong>${e.commande[0].name}</strong> : ${plats}`;

            sidebar.prepend(div);
        }
    });
