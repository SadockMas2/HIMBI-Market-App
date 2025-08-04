@extends('layouts.app')


@section('content')

<style>
        body {
            background-image: url('{{ asset('images_sections/panier.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #f8f8f8;
        }

        .table-container {
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.85); /* fond semi-transparent */
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            max-width: 1100px;
            margin: 50px auto;
            backdrop-filter: blur(6px);
        }

        h3 {
            color: #ffc107;
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
            font-size: 28px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 16px;
            background-color: #1a1a1a;
        }

        th {
            background-color: #6b59a3;
            color: white;
            padding: 15px;
            text-transform: uppercase;
        }

        td {
            padding: 14px;
            background-color: #2a2a2a;
            color: #ddd;
            text-align: center;
        }

        img {
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        input[type="number"] {
            width: 70px;
            padding: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .btn-confirm {
            display: inline-block;
            margin: 30px auto 0;
            padding: 14px 40px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-confirm:hover {
            background-color: #218838;
        }

        .update-btn {
            border: none;
            background: none;
            color: #ffc107;
            font-size: 20px;
            cursor: pointer;
            padding-left: 5px;
        }

        .update-btn:hover {
            color: #ff9800;
        }

        .alert {
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        .alert-success {
            background-color: #2ecc71;
            color: white;
            text-align: center;
        }

        .alert-danger {
            background-color: #e74c3c;
            color: white;
            text-align: center;
        }

</style>

<div class="table-container">
    <h3>🛒 Mon Panier</h3>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ url('/home') }}" class="btn-confirm">⬅️ Retour à l'accueil</a>
    </div>

   
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($data->isEmpty())
        <p class="text-center">Votre panier est vide.</p>
    @else

    <form action="{{ url('update_cart_multiple') }}" method="POST">
        @csrf
        <table>
            <thead>
                <tr>
                    <th>Plat</th>
                    <th>Prix unitaire</th>
                    <th>Quantité actuelle</th>
                    <th>Modifier quantité</th>
                    <th>Total</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @php $grand_total = 0; @endphp
                @foreach($data as $item)
                    @php
                        $unit_price = $item->price / max($item->quantity, 1);
                        $total = $unit_price * $item->quantity;
                        $grand_total += $total;
                    @endphp
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>${{ number_format($unit_price, 2, '.', ',') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            <input type="number" name="quantity[]" value="{{ $item->quantity }}" min="1" required>
                            <input type="hidden" name="cart_id[]" value="{{ $item->id }}">
                        </td>
                        <td>${{ number_format($total, 2, '.', ',') }}</td>
                        <td>
                            <img src="{{ asset('food_img/' . $item->image) }}" width="80" style="border-radius: 8px;">
                            <br>
                            <a href="{{ url('remove_cart/' . $item->id) }}" onclick="return confirm('Supprimer ce plat ?')" style="color: #e74c3c;">❌ Supprimer</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Le montant total de cette commande est : ${{ number_format($grand_total, 2, '.', ',') }}</h3>

        <button type="submit" class="btn-confirm">🔄 Mettre à jour les quantités</button>
    </form>

    {{-- Formulaire séparé pour confirmer la commande --}}
    <form action="{{ url('confirm_order') }}" method="POST" style="margin-top: 30px;">
        @csrf

        @foreach($data as $item)
            <input type="hidden" name="food_id[]" value="{{ $item->food_id }}">
            <input type="hidden" name="title[]" value="{{ $item->title }}">
            <input type="hidden" name="quantity[]" value="{{ $item->quantity }}">
            <input type="hidden" name="price[]" value="{{ number_format($item->price / max($item->quantity, 1), 2, '.', '') }}">
        @endforeach

        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
        <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
        <input type="hidden" name="adress" value="{{ Auth::user()->adress }}">

        <button type="submit" class="btn-confirm">✅ Confirmer la commande</button>
    </form>

    @endif
</div>

@endsection