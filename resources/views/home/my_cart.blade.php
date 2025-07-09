<!DOCTYPE html>
<html lang="fr">
<head>
    @include('home.css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - HIMBI Market</title>

    <style>
        body {
            background-color: #121212;
            color: #f1f1f1;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        nav.navbar {
            background-color: #222 !important;
        }

        .brand-txt {
            color: #fff;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            padding: 12px;
            text-align: center;
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
        }

        td {
            padding: 10px;
            text-align: center;
            color: #eee;
            background-color: #1f1f1f;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .div_center {
            max-width: 600px;
            margin: 30px auto;
            background: #1f1f1f;
            padding: 20px;
            border-radius: 12px;
        }

        .div_deg {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #ccc;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #888;
            background-color: #2c2c2c;
            color: #fff;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .table-container {
            overflow-x: auto;
            padding: 20px;
        }

        h3 {
            text-align: center;
            color: #f39c12;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }

            .navbar-brand {
                margin: 10px auto;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>

@if(session('success'))
    <div class="alert alert-success text-center mt-4">
        {{ session('success') }}
    </div>
@endif

<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

    <!-- NAVBAR -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#home">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">À propos</a></li>
                <li class="nav-item"><a class="nav-link" href="#gallary">Galerie</a></li>
                <li class="nav-item"><a class="nav-link" href="#book-table">Réserver</a></li>
            </ul>

            <a class="navbar-brand m-auto" href="{{ url('/') }}">
                <span class="brand-txt">HIMBI-Market</span>
            </a>

            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#blog">Plats</a></li>

                @if (Route::has('login'))
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ url('my_cart') }}">Panier</a></li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <input class="btn btn-sm btn-danger ml-2" type="submit" value="Déconnecter">
                        </form>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <!-- ESPACE -->
    <div style="margin-top: 100px;"></div>
    <br><br>

   

                <!-- FORMULAIRE GLOBAL -->
                <form action="{{ url('confirm_order') }}" method="POST">
                    @csrf

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Plat</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_price = 0; @endphp

                                @foreach ($data as $item)
                                    @php
                                        $subtotal = $item->price * $item->quantity;
                                        $total_price += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $item->title }}
                                            <input type="hidden" name="food_id[]" value="{{ $item->id }}">
                                            <input type="hidden" name="title[]" value="{{ $item->title }}">
                                        </td>
                                        <td>
                                            ${{ number_format($item->price, 2, '.', ',') }}
                                            <input type="hidden" name="price[]" value="{{ $item->price }}">
                                        </td>
                                        <td>
                                            {{ $item->quantity }}
                                            <input type="hidden" name="quantity[]" value="{{ $item->quantity }}">
                                        </td>
                                        <td>
                                            <img width="100" src="food_img/{{ $item->image }}" alt="">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h3>Le prix total pour cette commande est : ${{ number_format($total_price, 2, '.', ',') }}</h3>

                    <div class="div_center">
                        <div class="div_deg">
                            <label>Nom</label>
                            <input type="text" name="name" value="{{ Auth()->user()->name }}">
                        </div>

                        <div class="div_deg">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ Auth()->user()->email }}">
                        </div>

                        <div class="div_deg">
                            <label>Téléphone</label>
                            <input type="number" name="phone" value="{{ Auth()->user()->phone }}">
                        </div>

                        <div class="div_deg">
                            <label>Adresse</label>
                            <input type="text" name="adress" value="{{ Auth()->user()->adress }}">
                        </div>

                        <div class="div_deg text-center">
                            <input class="btn btn-info" type="submit" value="Confirmer la commande">
                        </div>
                    </div>
                </form>

</body>
</html>
