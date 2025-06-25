<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestion des commandes</title>

    @include('admin.css')

    <style>
        table {
            border: 1px solid rgb(26, 27, 27);
            margin: 20px auto;
            width: 800px;
            border-collapse: collapse;
        }
        th {
            color: rgb(154, 72, 72);
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            background-color: pink;
            padding: 8px;
            border: 1px solid rgb(33, 40, 44);
        }
        td {
            color: rgb(251, 250, 250);
            font-weight: 600;
            text-align: center;
            padding: 8px;
            border: 1px solid rgb(2, 8, 10);
            vertical-align: middle;
        }
        td img {
            border-radius: 8px;
            max-width: 100px;
            height: auto;
        }
        .btn {
            padding: 5px 10px;
            margin: 2px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-info { background-color: #17a2b8; }
        .btn-warning { background-color: #ffc107; color: black; }
        .btn-danger { background-color: #dc3545; }
        .btn:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>

    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <table>
                    <thead>
                        <tr>
                            <th>ID du plat</th>
                            <th>Nom Client</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Plat</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Image</th>
                            <th>Statut Livraison</th>
                            <th>Changer Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $order)
                            <tr>
                                <td>{{ $order->food_id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->adress }}</td>
                                <td>{{ $order->title }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ number_format($order->price, 2, ',', ' ') }} $</td>
                                <td>
                                    <img src="{{ asset('food_img/' . $order->image) }}" alt="Image de {{ $order->title }}" />
                                </td>
                                <td>{{ ucfirst($order->delivery_status) }}</td>
                                <td>
                                    <a 
                                       href="{{ url('on_the_way', $order->id) }}" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir changer ce statut en "En cours" ?');" 
                                       class="btn btn-info"
                                    >En cours</a>

                                    <a 
                                       href="{{ url('delivered', $order->id) }}" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir changer ce statut en "Livré" ?');" 
                                       class="btn btn-warning"
                                    >Livré</a>

                                    <a 
                                       href="{{ url('canceled', $order->id) }}" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?');" 
                                       class="btn btn-danger"
                                    >Annulé</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @include('admin.js')
</body>
</html>
