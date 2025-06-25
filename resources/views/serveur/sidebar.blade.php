<nav id="sidebar" class="bg-secondary text-white p-3" style="width: 250px; min-height: 100vh;">
    <div class="sidebar-header mb-4">
        <h5 class="text-white">Bienvenue, {{ Auth::user()->name }}</h5>
    </div>

    <ul class="list-unstyled">
        <li class="mb-2">
            <a href="{{ url('dashboard') }}" class="text-white d-flex align-items-center">
                <i class="fa fa-home me-2"></i> <span>Accueil</span>
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ url('showReservations') }}" class="text-white d-flex align-items-center">
                <i class="fa fa-list me-2"></i> <span>Réservations</span>
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ url('order') }}" class="text-white d-flex align-items-center">
                <i class="fa fa-calendar me-2"></i> <span>Commandes</span>
            </a>
        </li>
    </ul>
</nav>
