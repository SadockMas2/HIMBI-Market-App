@extends('admin.index')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Facture</h2>


            <p><strong>Commande #:</strong> {{ $order->id }}</p>
            <p><strong>Serveur:</strong> {{ $order->serveur->name ?? '---' }}</p>
            <p><strong>Table:</strong> {{ $order->table->nom_table ?? '---' }}</p>
            <p><strong>Plat:</strong> {{ $order->food->title ?? '---' }}</p>
            <p><strong>Quantité:</strong> {{ $order->quantite ?? $order->quantity }}</p>
            <p><strong>Prix unitaire:</strong> {{ $order->food->price ?? $order->price }} FC</p>
            <p><strong>Total:</strong> {{ ($order->food->price ?? $order->price) * ($order->quantite ?? $order->quantity) }} FC</p>


    <form method="POST" action="{{ url('marquer_paye', $order->id) }}">
        @csrf
        <button type="submit" class="btn btn-success mt-3">Marquer comme payé</button>
    </form>
</div>
@endsection
