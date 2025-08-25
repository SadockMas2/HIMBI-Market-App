<!-- Sidebar Toggle (mobile) -->
<button class="btn btn-primary d-md-none m-2" id="sidebarToggle">
    <i class="fa fa-bars"></i>
</button>

<!-- Sidebar -->
<nav id="sidebar" class="serveur-sidebar">
    <div class="sidebar-header mb-4 text-center">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=273469&color=fff&size=64"
             class="rounded-circle mb-2" alt="Avatar">
        <h6 class="fw-bold text-white mb-0">{{ Auth::user()->name }}</h6>
        <small class="text-muted">Rôle : Serveur</small>
    </div>

    <ul class="list-unstyled px-2">
        <li>
            <a href="{{ route('serveur.board') }}" class="sidebar-link">
                <i class="fa fa-tachometer-alt me-2"></i> Tableau de bord
            </a>
        </li>
        <li>
            <a href="{{ url('serveur/commandes-en-ligne') }}" class="sidebar-link">
                <i class="fa fa-receipt me-2"></i> Commandes en ligne
            </a>
        </li>
        <li>
            <a href="{{ url('nouvelle_commande') }}" class="sidebar-link">
                <i class="fa fa-plus-circle me-2"></i> Prendre une commande
            </a>
        </li>
        <li>
            <a href="{{ url('mesTables') }}" class="sidebar-link">
                <i class="fa fa-chair me-2"></i> Mes Tables
            </a>
        </li>
        <li>
            <a href="{{ url('showReservations') }}" class="sidebar-link">
                <i class="fa fa-calendar-alt me-2"></i> Réservations
            </a>
        </li>
        <li>
            <a href="{{ route('profile.show') }}" class="sidebar-link">
                <i class="fa fa-user-circle me-2"></i> Mon Profil
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="sidebar-link text-danger">
                <i class="fa fa-sign-out-alt me-2"></i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
