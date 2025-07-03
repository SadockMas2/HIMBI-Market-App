@extends('admin.index')

@section('content')
<div class="container my-5">
    <h2>Reçu de Paiement</h2>

    <p><strong>Commande #:</strong> {{ $commande->id }}</p>
    <p><strong>Date:</strong> {{ $commande->created_at->format('d/m/Y') }}</p>
    <p><strong>Serveur:</strong> {{ $commande->serveur->name }}</p>
    <p><strong>Table:</strong> {{ $commande->table->nom_table }}</p>
    <p><strong>Plat:</strong> {{ $commande->food->title }}</p>
    <p><strong>Quantité:</strong> {{ $commande->quantite }}</p>
    <p><strong>Total payé:</strong> {{ $commande->food->price * $commande->quantite }} FC</p>
    <p><strong>Status de paiement:</strong> {{ $commande->payment_status }}</p>

    <button onclick="window.print()" class="btn btn-primary mt-3">Imprimer le reçu</button>
</div>
@endsection
