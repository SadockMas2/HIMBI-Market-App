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
.client-header { background-color: #34495e; padding: 10px; border-radius: 5px; margin-bottom: 10px; }
</style>

<div class="content-wrapper">
    <h2>Commandes en ligne à prendre en charge</h2>

    @if($commandesFiltrees->count())
        @foreach($commandesFiltrees as $email => $commandesClients)
            @php
                $firstCommande = $commandesClients->first();
                $reservation = $firstCommande['reservation'];
                $commande = $firstCommande['commande'];
            @endphp

            @if(!$reservation || in_array($reservation->table_id, $tablesDisponibles->pluck('id')->toArray()))
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
                                        <input type="hidden" name="order_ids[]" value="{{ $commande->id }}">
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <select name="table_id" class="form-select w-50 me-2" required>
                                <option value="">-- Choisir une table --</option>
                                @foreach($tablesDisponibles as $table)
                                    <option value="{{ $table->id }}"
                                        @if($reservation && $reservation->table_id == $table->id) selected @endif>
                                        {{ $table->nom_table }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> Prendre en charge les commandes
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Aucune commande en cours pour ce serveur.
                </div>
            @endif
        @endforeach
    @else
        <div class="alert alert-info text-center">
            Aucune commande en ligne à prendre en charge pour ce serveur.
        </div>
    @endif
</div>
@endsection
