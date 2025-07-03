{{-- Mes Tables Assignées --}}

@extends('serveur.index')

@section('content')
<style>
    .page-content {
        max-width: 900px;
        margin: 40px auto 40px 270px;
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tables as $table)
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
                        <td>
                            {{-- Réservation --}}
                            @if($table->statut === 'Disponible')
                                <form action="{{ route('serveur.reserver_table') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="table_id" value="{{ $table->id }}">
                                    <button type="submit" class="btn btn-warning btn-sm">Réserver</button>
                                </form>
                            @endif

                            {{-- Paiement Réservation --}}
                            @if($table->statut === 'Réservée' && $table->reservation)
                                <form action="{{ route('serveur.reservation.payer', $table->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Payer Réservation</button>
                                </form>

                                <a href="{{ route('facture.reservation', $table->id) }}" target="_blank" class="btn btn-primary btn-sm">Facture Réservation</a>

                                @if($table->reservation->payment_status === 'payé')
                                    <a href="{{ route('recu.reservation', $table->id) }}" target="_blank" class="btn btn-secondary btn-sm">Reçu Réservation</a>
                                @endif
                            @endif

                            {{-- Commandes --}}
                            @php
                                $nonPayees = $table->commandes->where('payment_status', 'non_payé');
                                $payees = $table->commandes->where('payment_status', 'payé');
                            @endphp

                            @if($nonPayees->count() || $payees->count())
                                <hr>
                                <strong>Commandes :</strong><br><br>

                                {{-- Commandes non payées --}}
                                @if($nonPayees->count())
                                    <div>
                                        <strong>Commandes en attente :</strong><br>
                                        @foreach($nonPayees as $cmd)
                                            • {{ $cmd->food->title ?? 'Produit inconnu' }} x{{ $cmd->quantite }}<br>
                                        @endforeach

                                        <form action="{{ route('serveur.commandes.payer_groupes', $table->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm mt-2">Payer Commandes</button>
                                        </form>

                                        <a href="{{ route('facture.commandes', $table->id) }}" target="_blank" class="btn btn-primary btn-sm">Facture</a>
                                    </div>
                                @endif

                                {{-- Commandes payées --}}
                                @if($payees->count())
                                    <div class="mt-3">
                                        <strong>Commandes payées :</strong><br>
                                        @foreach($payees as $cmd)
                                            • {{ $cmd->food->title ?? 'Produit inconnu' }} x{{ $cmd->quantite }}<br>
                                        @endforeach
                                        <a href="{{ route('recu.commandes', $table->id) }}" target="_blank" class="btn btn-secondary btn-sm mt-2">Reçu</a>
                                    </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucune table assignée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
