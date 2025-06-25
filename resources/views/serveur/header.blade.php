<header class="header">
    <nav class="navbar navbar-expand-lg bg-dark text-white px-4 d-flex justify-content-between align-items-center">

        <!-- Gauche : Logo + Titre -->
        <a class="navbar-brand text-white d-flex align-items-center" href="#">
            <i class="fa fa-utensils me-2 text-white"></i> 
            <span class="fw-bold fs-4">
                <span style="color: #007bff;">HIMBI</span>
                <span style="color: #dc3545;">Market</span>
            </span>
        </a>

        <!-- Centre : Notification -->
        <div class="position-relative">
            <a href="{{ url('serveur/notifications') }}" class="text-white d-flex align-items-center justify-content-center">
                <i class="fa fa-bell fa-lg"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                    <span class="visually-hidden">notifications</span>
                </span>
            </a>
        </div>

        <!-- Droite : Déconnexion -->
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <input class="btn btn-outline-light" type="submit" value="Déconnecter">
        </form>

    </nav>
</header>
