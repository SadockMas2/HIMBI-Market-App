@extends('layouts.admin_layout')

@section('title', 'Commandes Clients')

@push('styles')
<style>
    body {
        background-color: #1e1e2f;
        font-family: 'Segoe UI', sans-serif;
        color: #f5f5f5;
        margin: 0;
    }

    .client-card {
        background-color: #2c2f48;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .client-header {
        font-size: 20px;
        font-weight: bold;
        color: #ffc107;
        margin-bottom: 15px;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-table th,
    .order-table td {
        border: 1px solid #444;
        padding: 10px;
        text-align: center;
    }

    .order-table th {
        background-color: #343a40;
        color: #ffffff;
        font-size: 15px;
    }

    .order-table td {
        background-color: #2a2e3a;
        font-size: 14px;
    }

    .order-table img {
        max-width: 60px;
        border-radius: 6px;
    }

    .total {
        text-align: right;
        font-weight: bold;
        color: #4caf50;
        margin-top: 10px;
    }

    .btn {
        padding: 5px 10px;
        margin: 2px;
        border-radius: 4px;
        font-size: 12px;
        text-decoration: none;
        color: white;
        font-weight: bold;
        display: inline-block;
    }

    .btn-info { background-color: #17a2b8; }
    .btn-warning { background-color: #ffc107; color: black; }
    .btn-danger { background-color: #dc3545; }
    .btn:hover {
        opacity: 0.85;
    }

    /* Container for the bottom buttons */
    .bulk-actions {
        margin-top: 15px;
        text-align: right;
    }
</style>
@endpush

@section('content')



<h2 style="color: white; margin-bottom: 30px;">Liste des commandes groupées par client</h2>

@if(session('success'))
    <div style="color: #4caf50; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

@foreach ($groupedOrders as $email => $orders)
    @php
        $client = $orders->first();
        $total = $orders->sum('price');
    @endphp

    <div class="client-card">
        <div class="client-header">
            {{ $client->name }} — {{ $client->email }} | {{ $client->phone }} | {{ $client->adress }}
        </div>

        <table class="order-table">
            <thead>
                <tr>
                    <th>Plat</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->title }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ number_format($order->price, 2, ',', ' ') }} $</td>
                        <td>
                            <img src="{{ asset('food_img/' . $order->image) }}" alt="{{ $order->title }}">
                        </td>
                        <td>{{ ucfirst($order->delivery_status) }}</td>
                        <td>
                            @if($order->delivery_status == 'en cours')
                                <a href="{{ url('on_the_way', $order->id) }}" class="btn btn-info">En cours</a>
                            @endif
                            <a href="{{ url('delivered', $order->id) }}" class="btn btn-warning">Livré</a>
                            <a href="{{ url('canceled', $order->id) }}" class="btn btn-danger">Annulé</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="bulk-actions">
            <a href="{{ route('deliver_all', $email) }}" class="btn btn-warning">Livrer tout le panier</a>
            <a href="{{ route('cancel_all', $email) }}" class="btn btn-danger">Annuler tout le panier</a>
        </div>

        <div class="total">
            Total: {{ number_format($total, 2, ',', ' ') }} $
        </div>
    </div>
@endforeach

@endsection
