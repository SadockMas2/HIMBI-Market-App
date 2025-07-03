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

      
            <table class="table table-bordered table-striped table-hover text-white">
                <thead class="table-dark">
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
                    
                        @foreach ($data as $data )
                            
                      
                    <tr>
                                <td>{{ $data->food_id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->phone }}</td>
                                <td>{{ $data->adress }}</td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->quantity }}</td>
                                <td>{{ number_format($data->price, 2, ',', ' ') }} $</td>
                                <td>
                                    <img src="{{ asset('food_img/' . $data->image) }}" alt="Image de {{ $data->title }}" />
                    </tr>
                    @endforeach
                </tbody>
            </table>
   
    </div>
@endsection
