<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Historique des Commandes Payées</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #ffffff;
            color: #2c3e50;
            margin: 30px;
            font-size: 14px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #34495e;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }

        .table-container {
            max-width: 1000px;
            margin: auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background-color: #34495e;
            color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-row {
            background-color: #ecf0f1;
            font-weight: bold;
        }

        .currency {
            text-align: right;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
        }

        @media screen and (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #ccc;
                padding: 10px;
                border-radius: 6px;
                background-color: #fdfdfd;
            }

            td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                text-align: left;
                font-weight: bold;
                color: #2c3e50;
            }

            .total-row {
                background-color: #dfe6e9;
            }
        }
    </style>
</head>
<body>

    <h2>Historique des Commandes Payées</h2>

    <div class="table-container">

                    @if($filtreServeur || $filtreDate)
                <p style="text-align:center; font-size:13px; color:#7f8c8d;">
                    @if($filtreServeur)
                        Serveur : <strong>{{ $filtreServeur }}</strong><br>
                    @endif
                    @if($filtreDate)
                        Date : <strong>{{ \Carbon\Carbon::parse($filtreDate)->format('d/m/Y') }}</strong>
                    @endif
                </p>
            @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Serveur</th>
                    <th>Plat</th>
                    <th>Quantité</th>
                    <th>Date</th>
                    <th>Prix Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commandes as $commande)
                    @php
                        $prix = is_numeric($commande->food->price) ? (float) $commande->food->price : 0;
                        $quantite = (int) $commande->quantite;
                        $ligneTotal = $prix * $quantite;
                    @endphp
                    <tr>
                        <td data-label="ID">{{ $commande->id }}</td>
                        <td data-label="Serveur">{{ $commande->serveur->name ?? 'Inconnu' }}</td>
                        <td data-label="Plat">{{ $commande->food->title ?? 'N/A' }}</td>
                        <td data-label="Quantité">{{ $quantite }}</td>
                        <td data-label="Date">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td data-label="Prix Total" class="currency">{{ number_format($ligneTotal, 2, ',', ' ') }} $</td>
                    </tr>
                @endforeach

                <tr class="total-row">
                    <td colspan="5" data-label="Total Général">Total Général</td>
                    <td class="currency"><strong>{{ number_format($totalCommandes, 2, ',', ' ') }} $</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        HIMBI Market — Merci de votre confiance ✨
    </div>
</body>
</html>
