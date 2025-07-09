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

    @include('home.css')

    <style>
        /* Ajout ou remplacement dans foodhut.css recommandé */

        header.header {
            background-image: url('/assets/images/header-bg.jpg'); /* Remplace avec le vrai chemin */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            position: relative;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.6);
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            text-align: center;
        }

        .overlay h1 {
            font-size: 2.5rem;
            color: #ffffff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }

        .overlay h2 {
            font-size: 1.5rem;
            color: #e0f7fa;
            margin-bottom: 20px;
        }

        .overlay .btn {
            padding: 12px 25px;
            font-size: 1rem;
            background-color: #ff214f;
            border: none;
            border-radius: 8px;
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .overlay .btn:hover {
            background-color: #d91c44;
        }

        @media (max-width: 768px) {
            .overlay h1 {
                font-size: 2rem;
            }

            .overlay h2 {
                font-size: 1.2rem;
            }

     .card-title {
        font-size: 1.2rem;
        font-weight: bold;
    }
    .form-check-label {
        color: #ddd;
    }
    .card {
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.02);
    }

            }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home"><i class="ti-home"></i> Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about"><i class="ti-user"></i> À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallary"><i class="ti-menu-alt"></i> Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#book-table"><i class="ti-calendar"></i> Réserver</a>
                </li>
            </ul>

            <a class="navbar-brand m-auto" href="{{ url('/') }}">
                <img src="#" class="brand-img" alt="">
                <span class="brand-txt">HIMBI Market</span>
            </a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#blog"><i class="ti-bookmark-alt"></i> Plats</a>
                </li>

                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('my_cart') }}"><i class="ti-shopping-cart"></i> Panier</a>
                        </li>
                        <form action="{{ route('logout') }}" method="POST" class="ml-3">
                            @csrf
                            <input type="submit" class="btn btn-sm btn-danger" value="Déconnecter">
                        </form>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="ti-user"></i> Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="ti-pencil-alt"></i> S'enregistrer</a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <!-- Header -->
    <header id="home" class="header">
        <div class="overlay text-white text-center">
            <h1 class="display-2 font-weight-bold my-3">Himbi Market</h1>
            <h2 class="display-4 mb-5">Votre table, notre passion !</h2>
            <a class="btn btn-lg btn-primary" href="#gallary">Voir Notre Galerie</a>
        </div>
    </header>

    @include('home.about')
    @include('home.gallary')
    @include('home.book')
    @include('home.blog')
    @include('home.footer')

</body>
</html>
