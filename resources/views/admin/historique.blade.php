@extends('layouts.admin_layout')

@section('content')

<div class="container-fluid">
    <div class="page-header py-3">
        <h2 class="text-center">Historique des Commandes Payées</h2>
    </div>

    <!-- 🔍 Formulaire de filtre -->
    <form method="GET" action="{{ url('historique') }}" class="row g-3 mb-4 bg-light p-3 rounded shadow-sm">
        <div class="col-md-4">
            <label for="serveur_id" class="form-label fw-bold">Filtrer par Serveur</label>
            <select name="serveur_id" id="serveur_id" class="form-select">
                <option value="">-- Tous les serveurs --</option>
                @foreach($serveurs as $s)
                    <option value="{{ $s->id }}" {{ request('serveur_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="date" class="form-label fw-bold">Filtrer par Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
        </div>

        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-1"></i> Rechercher</button>
            <a href="{{ route('admin.historique') }}" class="btn btn-secondary w-100"><i class="fa fa-undo me-1"></i> Réinitialiser</a>
        </div>
    </form>

    <!-- 📄 Bouton Export PDF -->
    <div class="mb-3 text-end">
        <a href="{{ route('admin.historique.pdf', request()->only(['serveur_id', 'date'])) }}" class="btn btn-danger">
            <i class="fa fa-file-pdf me-1"></i> Exporter en PDF
        </a>
    </div>

    <!-- 📋 Tableau des commandes -->
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Serveur</th>
                    <th>Plat</th>
                    <th>Quantité</th>
                    <th>Date</th>
                    <th>Statut Paiement</th>
                    <th>Prix Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                    @php
                        $prix = is_numeric($commande->food->price) ? (float) $commande->food->price : 0;
                        $quantite = (int) $commande->quantite;
                        $ligneTotal = $prix * $quantite;
                    @endphp
                    <tr>
                        <td>{{ $commande->id }}</td>
                        <td>{{ $commande->serveur->name ?? 'Inconnu' }}</td>
                        <td>{{ $commande->food->title ?? 'N/A' }}</td>
                        <td>{{ $commande->quantite }}</td>
                        <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($commande->payment_status) }}</td>
                        <td>{{ number_format($ligneTotal, 2, ',', ' ') }} $</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Aucune commande trouvée.</td>
                    </tr>
                @endforelse

                @if($commandes->count())
                    <tr class="table-info fw-bold">
                        <td colspan="6" class="text-end">Total Général</td>
                        <td>{{ number_format($totalCommandes, 2, ',', ' ') }} $</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
