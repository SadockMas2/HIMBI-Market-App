<!-- Sidebar Toggle (mobile) -->
<button class="btn btn-primary d-md-none m-2" id="sidebarToggle">
    <i class="fa fa-bars"></i>
</button>

<!-- Son de notification -->
<audio id="notifSound" src="{{ asset('assets/sounds/alerte.mp3') }}" preload="auto"></audio>

<!-- Sidebar -->
<nav id="sidebar" class="serveur-sidebar">
    <div class="sidebar-header mb-4 text-center">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=273469&color=fff&size=64"
             class="rounded-circle mb-2" alt="Avatar">
        <h6 class="fw-bold text-white mb-0">{{ Auth::user()->name }}</h6>
        <small class="text-muted">Rôle : Serveur</small>
    </div>

    <!-- Zone notifications -->
    <div id="sidebarNotifications" class="mb-3" style="max-height: 200px; overflow-y: auto; padding: 5px;"></div>

    <ul class="list-unstyled px-2">
        <span id="notifBadge" class="badge bg-danger">0</span>

        <li><a href="{{ route('serveur.board') }}" class="sidebar-link"><i class="fa fa-tachometer-alt me-2"></i> Tableau de bord</a></li>
        <li><a href="{{ url('serveur/commandes-en-ligne') }}" class="sidebar-link"><i class="fa fa-receipt me-2"></i> Commandes en ligne</a></li>
        <li><a href="{{ url('nouvelle_commande') }}" class="sidebar-link"><i class="fa fa-plus-circle me-2"></i> Prendre une commande</a></li>
        <li><a href="{{ url('mesTables') }}" class="sidebar-link"><i class="fa fa-chair me-2"></i> Mes Tables</a></li>
        <li><a href="{{ url('showReservations') }}" class="sidebar-link"><i class="fa fa-calendar-alt me-2"></i> Réservations</a></li>
        <li><a href="{{ route('profile.show') }}" class="sidebar-link"><i class="fa fa-user-circle me-2"></i> Mon Profil</a></li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link text-danger">
                <i class="fa fa-sign-out-alt me-2"></i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </li>
    </ul>
</nav>

<!-- Bouton pour débloquer le son -->
<button id="enableNotificationsBtn" class="btn btn-sm btn-light" style="position:fixed; bottom:12px; right:12px; z-index:9999;">
    Activer notifications
</button>

<!-- SCRIPT POLLING -->
<script>
(function () {
    const endpoint = "{{ route('serveur.orders.stream') }}"; // route Laravel
    const sidebar = document.getElementById('sidebarNotifications');
    const badge   = document.getElementById('notifBadge');
    const audio   = document.getElementById('notifSound');
    const enableBtn = document.getElementById('enableNotificationsBtn');

    const fetchOptions = { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } };
    let lastId = parseInt(localStorage.getItem('lastOrderId') || '0', 10) || 0;

    // Déblocage audio
    if (enableBtn) {
        enableBtn.addEventListener('click', () => {
            audio.play().then(()=> audio.pause()).catch(()=>{});
            enableBtn.style.display = 'none';
        });
    }
    document.addEventListener('click', function unlock() {
        audio.play().then(()=> audio.pause()).catch(()=>{});
        document.removeEventListener('click', unlock);
    }, { once: true });

    async function poll() {
        try {
            const res = await fetch(endpoint + "?since=" + lastId, fetchOptions);
            if (!res.ok) return;
            const data = await res.json();

            // Init (premier appel)
            if (lastId === 0 && data.max_id) {
                lastId = data.max_id;
                localStorage.setItem('lastOrderId', lastId);
                return;
            }

            if (data.orders && data.orders.length) {
                // son
                audio.play().catch(()=>{});
                // badge
                badge.innerText = parseInt(badge.innerText) + data.orders.length;
                // sidebar
                data.orders.forEach(o => {
                    const div = document.createElement('div');
                    div.className = 'alert alert-info';
                    div.style.background = '#34495e';
                    div.style.color = '#fff';
                    div.style.padding = '8px';
                    div.style.marginBottom = '5px';
                    div.style.borderRadius = '6px';
                    div.innerHTML = `<strong>${o.client_name}</strong> : ${o.title} x ${o.quantity}`;
                    sidebar.prepend(div);
                    setTimeout(()=>div.remove(), 10000);
                });
            }

            if (data.max_id > lastId) {
                lastId = data.max_id;
                localStorage.setItem('lastOrderId', lastId);
            }
        } catch(e) { console.log("poll error", e); }
    }

    setInterval(poll, 4000);
    poll();
})();
</script>
