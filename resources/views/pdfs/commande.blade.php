<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture HIMBI-Market</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
        }

        .infos-shop {
            font-size: 12px;
            text-align: center;
            line-height: 1.4;
        }

        .facture-meta {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            font-size: 14px;
        }

        .facture-meta div {
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        tfoot td {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>HIMBI-MARKET</h2>
        <div class="infos-shop">
            N° Impôt : AXXXXXXXX<br>
            RCCM : 18-A-XXXXX<br>
            Av. du Commerce, GOMA-HIMBI<br>
            Galerie ARIANA (GRABEN)<br>
            Tél : (+243) 99 345 23 45, E-mail : himbi.market@gmail.com
        </div>
    </div>

    <div class="facture-meta">
        <div>
            <strong>Mr/Mme :</strong> {{ $name }}<br>
            <strong>Téléphone :</strong> {{ $phone }}<br>
            <strong>Email :</strong> {{ $email }}<br>
            <strong>Adresse :</strong> {{ $adress }}
        </div>
        <div style="text-align: right;">
            <strong>Facture N° :</strong> FAC-{{ date('Ymd-His') }}<br>
            <strong>Goma, le :</strong> {{ date('d/m/Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Qté</th>
                <th>Désignation</th>
                <th>P.U</th>
                <th>P.T</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($orders as $order)
                @php
                    $sous_total = $order['quantity'] * $order['price'];
                    $total += $sous_total;
                @endphp
                <tr>
                    <td>{{ $order['quantity'] }}</td>
                    <td>{{ $order['title'] }}</td>
                    <td>{{ number_format($order['price'], 2) }} $</td>
                    <td>{{ number_format($sous_total, 2) }} $</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;">TOTAL</td>
                <td>{{ number_format($total, 2) }} $</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Les marchandises vendues ne sont ni reprises ni échangées
    </div>

</body>
</html>
