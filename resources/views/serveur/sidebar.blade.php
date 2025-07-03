<!-- Sidebar Toggle (mobile) -->
<button class="btn btn-secondary d-md-none m-2" id="sidebarToggle">
    <i class="fa fa-bars"></i>
</button>

<!-- Sidebar -->
<nav id="sidebar" class="bg-dark text-white p-3 position-fixed top-0 start-0 h-100" style="width: 250px; z-index: 1050; transition: transform 0.3s ease;">
    <div class="sidebar-header mb-4">
        <h5 class="text-white">Bienvenue, {{ Auth::user()->name }}</h5>
        <small>Rôle : Serveur</small>
    </div>

    <ul class="list-unstyled">
        <li class="mb-3">
            <a href="{{ url('serveur/dashboard') }}" class="text-white d-flex align-items-center">
                <i class="fa fa-home me-2"></i> <span>Accueil</span>
            </a>
        </li>

        <li class="mb-3">
            <a href="{{ url('serveur/commandes-en-ligne') }}" class="text-white d-flex align-items-center">
                <i class="fa fa-receipt me-2"></i> <span> Commandes en ligne</span>
            </a>
        </li>

        <li class="mb-3">
            <a href="{{ url('nouvelle_commande') }}" class="text-white d-flex align-items-center">
                <i class="fa fa-plus-circle me-2"></i> <span>Prendre une commande</span>
            </a>
        </li>

        <li class="mb-3">
            <a href="{{ url('mesTables') }}" class="text-white d-flex align-items-center">
                <i class="fa fa-chair me-2"></i> <span>Mes Tables</span>
            </a>
        </li>

        <li class="mb-3">
            <a href="{{ url('showReservations') }}" class="text-white d-flex align-items-center">
                <i class="fa fa-calendar-check me-2"></i> <span>Réservations</span>
            </a>
        </li>


        <li class="mb-3">
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="text-white d-flex align-items-center">
                <i class="fa fa-sign-out-alt me-2"></i> <span>Déconnexion</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>

<!-- Responsive Style -->
<style>
  @media (min-width: 768px) {
    #main-content {
      margin-left: 250px;
    }
  }

  @media (max-width: 768px) {
    #main-content {
      margin-left: 0;
    }
  }

  #sidebar {
    overflow-y: auto; /* Permet de scroller si le sidebar est plus long que l'écran */
  }
</style>

<!-- Sidebar Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            document.body.classList.toggle('sidebar-open');
        });
    });
</script>
