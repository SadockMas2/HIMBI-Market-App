@extends('layouts.app')

@section('content')

<style>
/* === Background et container === */
body {
    background-image: url('{{ asset('images_sections/panier.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #f8f8f8;
}

.table-container {
    padding: 30px;
    background-color: rgba(0, 0, 0, 0.85);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
    max-width: 1200px;
    margin: 40px auto;
    backdrop-filter: blur(6px);
}

h3 {
    color: #ffc107;
    text-align: center;
    font-weight: bold;
    margin-bottom: 25px;
    font-size: 26px;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
    border-radius: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
    min-width: 700px;
    background-color: #1a1a1a;
}

th {
    background-color: #6b59a3;
    color: white;
    padding: 14px;
    text-transform: uppercase;
    font-size: 14px;
}

td {
    padding: 12px;
    background-color: #2a2a2a;
    color: #ddd;
    text-align: center;
    vertical-align: middle;
}

img {
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    margin-bottom: 5px;
}

input[type="number"] {
    width: 70px;
    padding: 6px;
    border-radius: 6px;
    border: 1px solid #555;
    background: #111;
    color: #fff;
    text-align: center;
}

.btn-confirm {
    display: inline-block;
    margin: 10px 5px;
    padding: 14px 35px;
    background: linear-gradient(45deg, #28a745, #218838);
    border: none;
    color: white;
    font-size: 17px;
    font-weight: bold;
    border-radius: 30px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-confirm:hover {
    background: linear-gradient(45deg, #218838, #1e7e34);
    box-shadow: 0 4px 15px rgba(0,0,0,0.5);
}

.btn-danger-link {
    color: #e74c3c;
    font-size: 14px;
    text-decoration: none;
}

.btn-danger-link:hover {
    color: #ff6b6b;
    text-decoration: underline;
}

.alert {
    padding: 12px 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 15px;
    text-align: center;
}

.alert-success { background-color: #2ecc71; color: white; }
.alert-danger { background-color: #e74c3c; color: white; }

@media (max-width: 768px) {
    h3 { font-size: 22px; }
    .btn-confirm { width: 100%; font-size: 16px; padding: 12px; }
    table { min-width: 0; font-size: 13px; }
    img { width: 50px; height: 50px; }
}
</style>

<div class="table-container">
    <h3>🛒 Mon Panier</h3>

    @if($data->isEmpty())
        <p class="text-center">Votre panier est vide.</p>
        <div class="text-center mt-3">
            <a href="{{ url('/home#gallary') }}" class="btn-confirm">⬅️ Retour au menu</a>
        </div>
    @else
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Plat</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grand_total = 0; @endphp
                        @foreach($data as $item)
                            @php
                                $unit_price = $item->price / max($item->quantity,1);
                                $total = $unit_price * $item->quantity;
                                $grand_total += $total;
                            @endphp
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>${{ number_format($unit_price,2) }}</td>
                                <td>
                                    <input type="number" name="quantity[]" value="{{ $item->quantity }}" min="1">
                                </td>
                                <td>${{ number_format($total,2) }}</td>
                                <td>
                                    <img src="{{ asset('food_img/' . $item->image) }}" width="60">
                                </td>
                                <td>
                                    <a href="{{ url('/remove_cart/' . $item->id) }}" class="btn-danger-link">Supprimer</a>
                                </td>
                            </tr>

                            {{-- Repasser les infos au checkout --}}
                            <input type="hidden" name="food_id[]" value="{{ $item->food_id }}">
                            <input type="hidden" name="title[]" value="{{ $item->title }}">
                            <input type="hidden" name="price[]" value="{{ $unit_price }}">
                            <input type="hidden" name="cart_id[]" value="{{ $item->id }}">
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3>Total : ${{ number_format($grand_total,2) }}</h3>
            <div class="text-center mt-3">
                <button type="submit" formaction="{{ url('/update_cart_multiple') }}" class="btn-confirm">💾 Mettre à jour les quantités</button>
        
                <a href="{{ url('/home#gallary') }}" class="btn-confirm">⬅️ Nouveau Plat</a>
              <button type="submit" class="btn-confirm">➡️ Suivant</button>
            </div>
        </form>
    @endif
</div>

@endsection
