<!DOCTYPE html>
<html>
<head>
    <title>Facture - Commandes</title>
   <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
            color: #333;
            font-size: 14px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        thead {
            background-color: #2c3e50;
            color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
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
            color: #777;
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Facture des Commandes</h1>
    <table>
        <thead>
            <tr>
                <th>Plat</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $cmd)
                <tr>
                    <td>{{ $cmd->food->title }}</td>
                    <td>{{ $cmd->quantite }}</td>
                    <td>{{ $cmd->food->price }}$ </td>
                    @php
                        $prix = is_numeric($cmd->food->price) ? (float)$cmd->food->price : 0;
                        $quantite = (int) $cmd->quantite;
                        $ligneTotal = $prix * $quantite;
                    @endphp
                    <td>{{ $ligneTotal }} $</td>

                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>{{ $total }} $</strong></td>
            </tr>
        </tbody>
    </table>

            
                <div class="footer">
                    HIMBI Market &mdash; Merci pour votre confiance.
                 </div>
</body>
</html>
