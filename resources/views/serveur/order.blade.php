@extends('serveur.index')
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
@section('content')
    <div class="container-fluid">
        <h2>Commandes des clients</h2>

                    
                        <table>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Commandes</th>
                            <th>Total général ($)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedOrders as $email => $orders)
                            @php
                                $client = $orders->first();
                                $totalClient = $orders->sum('price');
                            @endphp
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->adress }}</td>
                                <td>
                                    <ul style="list-style:none; padding-left:0; text-align:left;">
                                        @foreach ($orders as $order)
                                            <li>{{ $order->title }} x {{ $order->quantity }} ({{ number_format($order->price, 2, ',', ' ') }} $)</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td><strong>{{ number_format($totalClient, 2, ',', ' ') }}</strong></td>
                                <td>
                                    {{-- Exemple simple d’action sur la première commande du client --}}
                                    <a href="{{ url('on_the_way', $client->id) }}" class="btn btn-info">En cours</a>
                                    <a href="{{ url('delivered', $client->id) }}" class="btn btn-warning">Livré</a>
                                    <a href="{{ url('canceled', $client->id) }}" class="btn btn-danger">Annulé</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

    </div>
@endsection


