<header class="serveur-header">
    <nav class="navbar navbar-expand-lg navbar-dark px-3">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
            <i class="fa fa-utensils me-2 text-warning fs-4"></i>
            <span class="fs-4">
                <span style="color: #00d9ff;">HIMBI</span>
                <span style="color: #ff4757;">Market</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-3 d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=32" 
                         class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                    <span class="fw-semibold">{{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="fa fa-sign-out-alt me-1"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>
