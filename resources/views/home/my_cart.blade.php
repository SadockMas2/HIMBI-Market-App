@extends('home.index')

@section('content')

<style>
    /* Styles identiques à ceux que tu avais */
    .table-container {
        padding: 30px;
        background-color: #1f1f1f;
        border-radius: 10px;
        color: #fff;
        max-width: 1000px;
        margin: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        color: #ddd;
    }

    th, td {
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #e74c3c;
        color: white;
    }

    td {
        background-color: #2c2c2c;
    }

    h3 {
        color: #f39c12;
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-confirm {
        display: block;
        margin: 20px auto;
        padding: 12px 30px;
        background-color: #3498db;
        border: none;
        color: #fff;
        border-radius: 6px;
        font-size: 16px;
    }

    .btn-confirm:hover {
        background-color: #2980b9;
    }

    input[type="number"] {
        width: 60px;
        text-align: center;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .update-btn {
        border: none;
        background: none;
        color: #f39c12;
        cursor: pointer;
        font-size: 18px;
    }

    .update-btn:hover {
        color: #d35400;
    }
</style>

<div class="table-container">

    <h3>🛒 Mon Panier</h3>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($data->isEmpty())
        <p class="text-center">Votre panier est vide.</p>
    @else
    <form action="{{ url('confirm_order') }}" method="POST">
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
                        <td>
                            {{ $item->title }}
                            {{-- Ces inputs seront envoyés dans confirm_order --}}
                            <input type="hidden" name="food_id[]" value="{{ $item->food_id }}">
                            <input type="hidden" name="title[]" value="{{ $item->title }}">
                        </td>
                        <td>${{ number_format($unit_price, 2, '.', ',') }}</td>
                        
                        {{-- Affichage quantité actuelle + champ caché --}}
                        <td>
                            {{ $item->quantity }}
                            <input type="hidden" name="quantity[]" value="{{ $item->quantity }}">
                        </td>

                        {{-- Formulaire de mise à jour quantité (indépendant) --}}
                        <td>
                            <form action="{{ url('update_cart/' . $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" required>
                                <button type="submit" class="update-btn" title="Mettre à jour">🔄</button>
                            </form>
                        </td>

                        <td>${{ number_format($total, 2, '.', ',') }}
                            <input type="hidden" name="price[]" value="{{ $unit_price }}">
                        </td>
                        <td>
                            <img src="{{ asset('food_img/' . $item->image) }}" width="80" style="border-radius: 8px;"><br>
                            <a href="{{ url('remove_cart/' . $item->id) }}" onclick="return confirm('Supprimer ce plat ?')" style="color: #e74c3c;">❌ Supprimer</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Le montant total de cette commande est : ${{ number_format($grand_total, 2, '.', ',') }}</h3>

        {{-- Données utilisateur (cachées) --}}
        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
        <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
        <input type="hidden" name="adress" value="{{ Auth::user()->adress }}">

        <button type="submit" class="btn-confirm">✅ Confirmer la commande</button>
    </form>
    @endif
</div>

@endsection
