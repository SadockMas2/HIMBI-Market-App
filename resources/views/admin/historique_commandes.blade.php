<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Historique des commandes du serveur #{{ request()->route('serveurId') }}</title>
    @extends('admin.index')
    @include('admin.css')
</head>
<body>

    @include('admin.header')
    @include('admin.sidebar')

    <!-- CONTENU PRINCIPAL -->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">Historique des commandes du serveur #{{ request()->route('serveurId') }}</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                @forelse ($commandes as $commande)
                    <div class="card mb-3 p-3" style="background-color:#2980b9; color:white; border-radius:10px;">
                        <h4>Commande ID : {{ $commande->id }}</h4>
                        <p>Plat : {{ $commande->food->title ?? 'N/A' }}</p>
                        <p>Quantité : {{ $commande->quantite }}</p>
                        <p>Statut commande : {{ $commande->statut }}</p>

                        <h5>Paiements :</h5>
                        @if($commande->payments->isEmpty())
                            <p>Aucun paiement enregistré</p>
                            <a href="{{ route('print.invoice', $commande->id) }}" class="btn btn-warning btn-sm">Imprimer Facture</a>
                        @else
                            @foreach ($commande->payments as $payment)
                                <p>
                                    Montant : {{ $payment->amount }}<br>
                                    Date : {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') }}<br>
                                    Statut : {{ $payment->status }}
                                </p>
                                @if($payment->status === 'payé')
                                    <a href="{{ route('print.receipt', $commande->id) }}" class="btn btn-success btn-sm">Imprimer Reçu</a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @empty
                    <div class="alert alert-info">Aucune commande enregistrée pour ce serveur.</div>
                @endforelse
            </div>
        </section>
    </div>

    @include('admin.js')
</body>
</html>
