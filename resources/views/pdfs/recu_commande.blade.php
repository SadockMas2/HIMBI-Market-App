<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu - HIMBI Market</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 30px;
            color: #2c3e50;
            background-color: #ffffff;
            font-size: 14px;
        }

        h1 {
            text-align: center;
            color: #2980b9;
            margin-bottom: 30px;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }

        .invoice-box {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            background-color: #fefefe;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #34495e;
            color: white;
        }

        th, td {
            padding: 12px 15px;
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

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        @media only screen and (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            td {
                padding-left: 50%;
                position: relative;
                text-align: right;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                padding-left: 15px;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h1>Reçu - HIMBI Market</h1>

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
                    @php
                        $prix = is_numeric($cmd->food->price) ? (float)$cmd->food->price : 0;
                        $quantite = (int) $cmd->quantite;
                        $ligneTotal = $prix * $quantite;
                    @endphp
                    <tr>
                        <td data-label="Plat">{{ $cmd->food->title }}</td>
                        <td data-label="Quantité">{{ $quantite }}</td>
                        <td data-label="Prix Unitaire">{{ number_format($prix, 2, ',', ' ') }} $</td>
                        <td data-label="Total">{{ number_format($ligneTotal, 2, ',', ' ') }} $</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">TOTAL</td>
                    <td><strong>{{ number_format($total, 2, ',', ' ') }} $</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            HIMBI Market &mdash; Merci pour votre fidélité 
        </div>
    </div>
</body>
</html>
