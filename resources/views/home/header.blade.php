@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>HIMBI Market | Goma</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @include('home.css')

    <style>
        /* === NAVBAR STYLÉE === */
        .custom-navbar {
            background-color: #1e1e1e;
            padding: 10px 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .custom-navbar .nav-link {
            background-color: transparent;
            color: #ffc107 !important;
            font-weight: 500;
            margin: 5px 8px;
            border: 1px solid transparent;
            border-radius: 30px;
            padding: 8px 18px;
            transition: all 0.3s ease-in-out;
        }

        .custom-navbar .nav-link:hover {
            background-color: #ffc107;
            color: #1e1e1e !important;
            border-color: #ffc107;
        }

        .custom-navbar .btn-nav {
            background-color: #17a2b8;
            color: white;
            font-weight: 500;
            border-radius: 30px;
            padding: 8px 20px;
            border: none;
            margin: 5px 8px;
            transition: all 0.3s;
        }

        .custom-navbar .btn-nav:hover {
            background-color: #138496;
            color: white;
        }

        .navbar-toggler {
            border-color: #ffc107;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23ffc107' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,193,7,1)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* === HEADER === */
        header.header {
            position: relative;
            height: 100vh;
            width: 100%;
            background-image: url('/images_sections/accueil.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        header.header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }

        .header-content {
            position: relative;
            z-index: 1;
            max-width: 900px;
            padding: 0 20px;
        }

        .header-content h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.7);
        }

        .header-content h2 {
            font-size: 1.8rem;
            font-weight: 400;
            margin-bottom: 2rem;
            color: #f0f9ff;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.6);
        }

        .header-content .btn-primary {
            background-color: #ff214f;
            border: none;
            padding: 14px 36px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 6px 15px rgba(255,33,79,0.5);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .header-content .btn-primary:hover {
            background-color: #d91c44;
            box-shadow: 0 8px 20px rgba(217,28,68,0.7);
            color: white;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .header-content h1 {
                font-size: 2.8rem;
            }

            .header-content h2 {
                font-size: 1.4rem;
            }

            .header-content .btn-primary {
                font-size: 1rem;
                padding: 12px 20px;
            }
        }

        @media (max-width: 56px) {
            .header-content h1 {
                font-size: 2.2rem;
            }

            .header-content h2 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="40" id="home">

<!-- NAVBAR -->
<nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-bs-spy="affix" data-bs-offset="10">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav text-center">
                <li class="nav-item"><a class="nav-link" href="#home"><i class="ti-home"></i> Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#gallary"><i class="ti-menu-alt"></i> Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#book"><i class="ti-calendar"></i> Réserver</a></li>
                <li class="nav-item"><a class="nav-link" href="#blog"><i class="ti-bookmark-alt"></i> Plats</a></li>
                <li class="nav-item"><a class="nav-link" href="#about"><i class="ti-user"></i> À propos</a></li>

                @if (Route::has('login'))
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ url('my_cart') }}"><i class="ti-shopping-cart"></i> Panier</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-warning fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti-user me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">👤 Mon Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">🚪 Se déconnecter</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-nav" href="{{ route('login') }}"><i class="ti-user"></i> Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-nav" href="{{ route('register') }}"><i class="ti-pencil-alt"></i> S'enregistrer</a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>

@if (session('commande_success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('commande_success') }}
        @if(session('pdf_url'))
            <a href="{{ session('pdf_url') }}" class="btn btn-sm btn-primary ml-3">📄 Télécharger le PDF</a>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<!-- HEADER -->
<header id="home" class="header">
    <div class="header-content">
        <h1>Himbi Market</h1>
        <h2>Votre table, notre passion !</h2>
        <a class="btn btn-primary" href="#gallary">Voir Notre Galerie</a>
    </div>

       
</header>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
