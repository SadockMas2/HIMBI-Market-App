{{-- Mes Tables Assignées --}}

@extends('serveur.index')

@section('content')
<style>
    .page-content {
        max-width: 900px;
        margin-left: 150px;
        /* margin: 40px auto 40px 270px; */
        padding: 30px 20px;
        background: #393838;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        color: white;
    }

    h2 {
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        font-size: 30px;
        color: #d1d7dc;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        font-size: 16px;
    }

    thead th {
        background-color: #061b29;
        color: #46a3ff;
        font-weight: 700;
        padding: 15px;
        border-radius: 10px 10px 0 0;
        text-align: center;
    }

    tbody tr {
        background-color: #00080c;
        transition: background-color 0.3s ease;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    tbody tr:hover {
        background-color: #1c5980;
    }

    tbody td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
    }

    .btn-sm {
        margin: 3px;
    }
</style>

<div class="page-content">
    <h2>Mes Tables Assignées</h2>

    @if(session('success'))
        <div style="color: limegreen; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Capacité</th>
                    <th>Statut</th>
                    <th>Commandes en attente</th>
                    <th>Commandes payées</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tables as $table)
                    @php
                        $nonPayees = $table->commandes->where('payment_status', 'non_payé');
                        $payees = $table->commandes->where('payment_status', 'payé');
                    @endphp
                    <tr>
                        <td>{{ $table->nom_table }}</td>
                        <td>{{ $table->capacite }}</td>
                        <td>
                            @if($table->statut === 'Disponible')
                                <span class="badge bg-success">{{ ucfirst($table->statut) }}</span>
                            @elseif($table->statut === 'occupée')
                                <span class="badge bg-danger">{{ ucfirst($table->statut) }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ ucfirst($table->statut) }}</span>
                            @endif
                        </td>

                        <td style="text-align: left;">
                            @if($nonPayees->count())
                                <ul>
                                    @foreach($nonPayees as $cmd)
                                        <li>{{ $cmd->food->title ?? 'Produit inconnu' }} x{{ $cmd->quantite }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>Aucune commande en attente</em>
                            @endif
                        </td>

                        <td style="text-align: left;">
                            @if($payees->count())
                                <ul>
                                    @foreach($payees as $cmd)
                                        <li>{{ $cmd->food->title ?? 'Produit inconnu' }} x{{ $cmd->quantite }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>Aucune commande payée</em>
                            @endif
                        </td>

                        <td>
                            {{-- Bouton pour payer toutes les commandes non payées --}}
                            @if($nonPayees->count())
                                <form action="{{ route('serveur.commandes.payer_groupes', $table->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm mb-1">Payer commandes</button>
                                </form>

                                <a href="{{ route('facture.commandes', $table->id) }}" target="_blank" class="btn btn-primary btn-sm mb-1">Facture</a>
                            @endif

                            {{-- Bouton pour voir le reçu si commandes payées --}}
                            @if($payees->count())
                                <a href="{{ route('recu.commandes', $table->id) }}" target="_blank" class="btn btn-secondary btn-sm">Reçu</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucune table assignée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
