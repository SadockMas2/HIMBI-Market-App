<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @include('serveur.css')
    <title>Serveur - Tableau de Bord</title>

    <!-- Meta pour Pusher/Echo si tu veux utiliser process.env -->
    <meta name="pusher-key" content="{{ env('PUSHER_APP_KEY') }}">
    <meta name="pusher-cluster" content="{{ env('PUSHER_APP_CLUSTER', 'mt1') }}">
    
    <style>
        /* Notifications sidebar fixe */
        .notification-sidebar {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 300px;
            z-index: 9999;
        }

        .notification {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="bg-dark text-white">

    @include('serveur.header')

    <div class="d-flex">
        @include('serveur.sidebar')

        <div class="content p-4" style="width: 100%;">
            @yield('content')
        </div>
    </div>

    <!-- Audio pour notification -->
    <audio id="notifSound" src="{{ asset('assets/sounds/alerte.mp3') }}" preload="auto"></audio>

    <!-- Sidebar pour afficher les notifications -->
    <div class="notification-sidebar" id="notificationSidebar"></div>

    <!-- Scripts Pusher & Echo -->
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
<script>
    Pusher.logToConsole = false;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env("PUSHER_APP_KEY") }}',
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        forceTLS: true
    });

    let alertInterval = null;
    let stopAlerts = false;

    function startAlerts(audio) {
        if (alertInterval || stopAlerts) return;

        function playCycle() {
            let loop = setInterval(() => audio.play().catch(()=>{}), 2000); // rejoue toutes les 2s
            setTimeout(() => clearInterval(loop), 10000); // stoppe après 10s
        }

        playCycle(); // première fois
        alertInterval = setInterval(playCycle, 30000); // toutes les 30s (10 ON / 20 OFF)
    }

    function stopAllAlerts(audio) {
        stopAlerts = true;
        if (alertInterval) {
            clearInterval(alertInterval);
            alertInterval = null;
        }
        audio.pause();
        audio.currentTime = 0;
    }

    Echo.channel('commandes')
        .listen('.commande.confirmee', (e) => {
            console.log("Nouvelle commande :", e);

            const audio = document.getElementById('notifSound');
            if (audio) startAlerts(audio); // 🔔 déclencher sonnerie en boucle

            const sidebar = document.getElementById('notificationSidebar');
            if(sidebar && e.commande.length){
                e.commande.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'notification';
                    div.innerHTML = `<strong>${item.client_name}</strong> : ${item.title} x ${item.quantity}`;
                    sidebar.prepend(div);
                    setTimeout(() => div.remove(), 30000);
                });
            }

            const badge = document.getElementById('notifBadge');
            if(badge){
                badge.textContent = parseInt(badge.textContent || 0) + e.commande.length;
            }
        });

    // Ex: arrêter les alertes quand le serveur ouvre "Commandes en ligne"
    document.querySelector('a[href="{{ url('serveur/commandes-en-ligne') }}"]')
        ?.addEventListener('click', () => stopAllAlerts(document.getElementById('notifSound')));
</script>


    @stack('scripts')
</body>
</html>
