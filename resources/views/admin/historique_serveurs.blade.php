@extends('admin.index')

@section('content')
<div class="page-content">
    <h2>Historique des commandes par serveurs</h2>
    <table>
        <thead>
            <tr>
                <th>Serveur</th>
                <th>Date</th>
                <th>Table</th>
                <th>Plat</th>
                <th>Quantité</th>
                <th>Statut</th>
                <th>Paiement</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
                <tr>
                    <td>{{ $commande->serveur->name }}</td>
                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $commande->table->nom_table }}</td>
                    <td>{{ $commande->food->title }}</td>
                    <td>{{ $commande->quantite }}</td>
                    <td>{{ ucfirst($commande->statut) }}</td>
                    <td>{{ ucfirst($commande->payment_status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
