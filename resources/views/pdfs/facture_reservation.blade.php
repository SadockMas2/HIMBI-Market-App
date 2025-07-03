<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Réservation #{{ $reservation->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            padding: 30px;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 26px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        .details, .summary {
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            background-color: #eef;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Facture de Réservation</h1>
        <p>Himbi Market - Service Réservation</p>
    </div>

    <div class="details">
        <p><strong>N° de Réservation :</strong> #{{ $reservation->id }}</p>
        <p><strong>Nom du Client :</strong> {{ $reservation->name }}</p>
        <p><strong>Téléphone :</strong> {{ $reservation->phone }}</p>
        <p><strong>Nombre d’invités :</strong> {{ $reservation->guest }}</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</p>
        <p><strong>Heure :</strong> {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</p>
        <p><strong>Table :</strong> {{ $reservation->table->nom_table ?? 'Non attribuée' }}</p>
        <p><strong>Statut du Paiement :</strong> {{ ucfirst($reservation->payment_status) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Réservation de la table {{ $reservation->table->nom_table ?? 'N/A' }}</td>
                <td>10 000 FC</td>
            </tr>
            <tr class="total">
                <td>Total à payer</td>
                <td>10 000 FC</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Merci pour votre réservation !<br>
        Pour toute question, contactez-nous au +243 xxx xxx xxx
    </div>

</body>
</html>
