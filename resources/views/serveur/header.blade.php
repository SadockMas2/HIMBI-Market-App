<header class="header shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, #0f2027, #203a43, #2c5364); padding: 0.75rem 2.5rem;">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <!-- Logo HIMBI Market -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fa fa-utensils me-2 text-warning fs-4"></i>
                <span class="fw-bold fs-4 text-white">
                    <span style="color: #00d9ff;">HIMBI</span>
                    <span style="color: #ff4757;">Market</span>
                </span>
            </a>

            <!-- Burger (responsive) -->
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu à droite -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-center mb-2 mb-lg-0">

                    <!-- Utilisateur -->
                    <li class="nav-item me-3 d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=32" 
                             alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                        <span class="text-white fw-semibold">{{ Auth::user()->name }}</span>
                    </li>

                    <!-- Déconnexion -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="fa fa-sign-out-alt me-1"></i> Déconnexion
                            </button>
                        </form>
                    </li>

                </ul>
            </div>

        </div>
    </nav>
</header>
