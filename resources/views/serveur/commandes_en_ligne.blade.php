@extends('serveur.index')

@section('content')
<style>
.content-wrapper { padding: 20px; min-height: 100vh; background: #1e1e2f; }
h2 { color: #00d9ff; text-align: center; margin-bottom: 30px; }
.table { background-color: #2c2c34; color: #fff; }
.table th { background-color: #6e8386; color: #000; text-align: center; }
.table td { vertical-align: middle; }
.form-select, .btn { font-size: 0.875rem; }
.btn-success { background-color: #28a745; border: none; }
.btn-success:hover { background-color: #218838; }
.alert-info { background-color: #34495e; color: #ecf0f1; border: none; }
.client-header { background-color: #c1cfdc; padding: 10px; border-radius: 5px; margin-bottom: 10px; }

/* Sidebar notifications */
.notification-sidebar {
    position: fixed;
    top: 10px;
    right: 10px;
    width: 300px;
    z-index: 9999;
}
.notification {
    background-color: #28a745;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 5px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
}
</style>

<div class="content-wrapper">
    <h2>Commandes en ligne à prendre en charge</h2>

    @if($commandesFiltrees->count())
        @foreach($commandesFiltrees as $email => $commandesClients)
            @php
                $firstCommande = $commandesClients->first();
                $commande = $firstCommande['commande'];
                $tableChoisie = $commande->table; // relation table() dans Order
            @endphp

            <div class="client-header">
                <strong>Client :</strong> {{ $commande->name }} |
                <strong>Email :</strong> {{ $commande->email }} |
                <strong>Téléphone :</strong> {{ $commande->phone }}
            </div>

            <div class="table-responsive mb-4">
                <form action="{{ route('serveur.prendre_commandes_client') }}" method="POST" class="card card-body bg-dark">
                    @csrf
                    <input type="hidden" name="serveur_id" value="{{ auth()->user()->id }}">

                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom du Plat</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Adresse</th>
                                <th>Table choisie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandesClients as $item)
                                @php $commande = $item['commande']; @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $commande->title }}</td>
                                    <td class="text-center">{{ $commande->quantity }}</td>
                                    <td class="text-end">{{ number_format($commande->price, 2, ',', ' ') }} $</td>
                                    <td>{{ $commande->adress }}</td>
                                    <td>{{ $commande->table ? $commande->table->nom_table : 'Non spécifiée' }}</td>
                                    <input type="hidden" name="order_ids[]" value="{{ $commande->id }}">
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <select name="table_id" class="form-select w-50 me-2" required>
                            <option value="">-- Choisir une table --</option>
                            @foreach($tablesDisponibles as $table)
                                @if($table->nom_table == ($tableChoisie->nom_table ?? ''))
                                    <!-- Affiche seulement les tables assignées au serveur qui correspondent au choix du client -->
                                    <option value="{{ $table->id }}" selected>{{ $table->nom_table }}</option>
                                @elseif($table->nom_table != ($tableChoisie->nom_table ?? ''))
                                    <!-- Sinon affiche les autres tables disponibles -->
                                    <option value="{{ $table->id }}">{{ $table->nom_table }}</option>
                                @endif
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Prendre en charge les commandes
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    @else
        <div class="alert alert-info text-center">
            Aucune commande en ligne à prendre en charge pour ce serveur.
        </div>
    @endif
</div>

<!-- Notifications sidebar -->
<div class="notification-sidebar" id="notificationSidebar"></div>
@endsection
