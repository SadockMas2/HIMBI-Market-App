<!DOCTYPE html>
<html lang="en">
<head>
	@include('home.css')

    <style>

        table
        {
            margin: 40px;
            border: 1px solid skyblue;
        }

        th
        {
            padding: 10px;
            text-align: center;
            background-color: red;
            color: white;
            font-weight: bold;
        }
        
        td
        {
            padding: 10px;
            color: white;
        }
        .div_center
        {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 50px;
        }

        label
        {
            display: inline-block;
            width: 200px;
        }
        .div_deg
        {
            padding: 10px;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
  <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">A propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallary">Galerie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#book-table">Reservez une table</a>
                </li>
            </ul>
            <a class="navbar-brand m-auto" href="{{ url('/') }}">
                <img src="assets/imgs/logo_SeedFood.png" class="brand-img" alt="">
                <span class="brand-txt">Seed Food</span>
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#blog">Plats<span class="sr-only">(current)</span></a>
                </li>

                    @if (Route::has('login'))
                      
                    @auth

                    
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('my_cart') }}">Panier</a>
                </li>
                
                    <form action="{{route('logout')}}" method="POST">
                                @csrf
                            <input class= "btn btn-primary ml-xl-4"
                             type="submit" value="Deconnecter">
                    </form>

                    @else


                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">Register</a>
                </li>


                    @endauth

                    @endif

                   


                
            </ul>
        </div>
    </nav>
    
</br></br></br></br></br>


                    <div  id="gallary" class="text-center bg-dark text-light has-height-md middle-items wow fadeIn">
        
                        <table>
                            <tr>
                                <th>Plat</th>
                                <th>Prix</th>
                                <th>Quanité</th>
                                <th>Image</th>
                                <th>Supprimer</th>
                            </tr>

                                 @php
                                    $total_price = 0;
                                @endphp

                                @foreach ($data as $item)
                                    @php
                                        $subtotal = $item->price * $item->quantity;
                                        $total_price += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td>${{ number_format($item->price, 2, '.', ',') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td><img width="150" src="food_img/{{ $item->image }}" alt=""></td>
                                        <td>
                                            <form action="{{ url('confirm_order') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="food_id" value="{{ $item->id }}">
                                                <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                                                <input type="hidden" name="name" value="{{ Auth()->user()->name }}">
                                                <input type="hidden" name="email" value="{{ Auth()->user()->email }}">
                                                <input type="hidden" name="phone" value="{{ Auth()->user()->phone }}">
                                                <input type="hidden" name="adress" value="{{ Auth()->user()->adress }}">
                                                <input class="btn btn-success" type="submit" value="Commander">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach


                      </table>

                        <h3>
                           Le prix total pour cette commande est: ${{ $total_price }}
                        </h3>
                    </div>


                        <div class="div_center">
                            <form action="{{ url('confirm_order') }}" method="post">
                                @csrf

                            <div class="div_deg">

                                <label for="">Nom</label>
                                <input type="text" name="name" value="{{ Auth()->user()->name}}">
                            </div>

                            <div class="div_deg">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{ Auth()->user()->email}}">
                            </div>

                            <div class="div_deg">
                                <label for="">Téléphone</label>
                                <input type="number" name="phone" value="{{ Auth()->user()->phone}}">
                            </div>

                            <div class="div_deg">
                                <label for="">Adresse</label>
                                <input type="text" name="adress" value="{{ Auth()->user()->adress}}">
                            </div>

                            <div class="div_deg">

                                <input class="btn btn-info" type="submit" value="Confirmez la commande">
                            </div>


                            </form>


                        </div>
</body>
</html>
