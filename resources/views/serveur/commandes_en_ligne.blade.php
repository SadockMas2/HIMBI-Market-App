@extends('serveur.index')

@section('content')
<style>
    .content-wrapper {
        margin-left: 250px;
        padding: 20px;
        min-height: 100vh;
        background-color: #1e1e2f;
        color: #f0f0f0;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            margin-left: 0;
            padding: 15px;
        }
    }

    h2 {
        text-align: center;
        color: #00d9ff;
        font-weight: bold;
        margin-bottom: 30px;
        text-shadow: 1px 1px 2px black;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        background-color: #2c2c3c;
        color: #fff;
    }

    .table th {
        background-color: #00d9ff;
        color: #000;
        text-align: center;
    }

    .table td {
        vertical-align: middle;
    }

    .form-select,
    .btn {
        font-size: 0.875rem;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .alert-info {
        background-color: #34495e;
        color: #ecf0f1;
        border: none;
    }

    ::-webkit-scrollbar {
        height: 6px;
    }

    ::-webkit-scrollbar-thumb {
        background: #00d9ff;
        border-radius: 3px;
    }

    .client-header {
        background-color: #34495e;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }
</style>

<div class="content-wrapper">
    <div class="container-fluid py-4">
        <h2>Commandes en ligne à prendre en charge</h2>

        @if($commandes->count())
            @foreach($commandes as $email => $commandesClient)
                @php $client = $commandesClient->first(); @endphp

                <div class="client-header">
                    <strong>Client :</strong> {{ $client->name }} |
                    <strong>Email :</strong> {{ $email }} |
                    <strong>Téléphone :</strong> {{ $client->phone }}
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
                                @foreach($commandesClient as $commande)
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
                                    <option value="{{ $table->id }}">{{ $table->nom_table }}</option>
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
                Aucune commande en ligne à prendre en charge pour l'instant.
            </div>
        @endif
    </div>
</div>
@endsection
