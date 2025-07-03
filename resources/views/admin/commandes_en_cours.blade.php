@extends('admin.layout')

@section('content')
<h1>Commandes en cours</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Table</th>
            <th>Serveur</th>
            <th>Plat</th>
            <th>Quantité</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($commandes as $commande)
        <tr>
            <td>{{ $commande->table->nom_table }}</td>
            <td>{{ $commande->serveur->name }}</td>
            <td>{{ $commande->food->title }}</td>
            <td>{{ $commande->quantite }}</td>
            <td>{{ ucfirst($commande->status) }}</td>
            <td>
                @if(!in_array($commande->status, ['terminee', 'payee']))
                <form action="{{ route('admin.commande.update_status', $commande->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <select name="status" onchange="this.form.submit()">
                        <option value="en_attente" {{ $commande->status == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_cours" {{ $commande->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminee" {{ $commande->status == 'terminee' ? 'selected' : '' }}>Terminée</option>
                        <option value="payee" {{ $commande->status == 'payee' ? 'selected' : '' }}>Payée</option>
                    </select>
                </form>
                @else
                <form action="{{ route('admin.table.liberer', $commande->table->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success btn-sm">Libérer table</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
