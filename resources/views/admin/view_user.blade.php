<!DOCTYPE html>
<html>
<head> 
    @include('admin.css')

    <style>
        .container-custom {
            max-width: 90%;
            margin: 40px auto;
            background-color: #2c3e50;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }

        h2 {
            text-align: center;
            color: #f1c40f;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
        }

        thead {
            background-color: skyblue;
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: white;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .alert-success {
            text-align: center;
            color: #2ecc71;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <div class="container-custom">
                    @if(session('success'))
                        <div class="alert-success">{{ session('success') }}</div>
                    @endif

                    <h2>Liste des Clients</h2>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Adresse</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->adress }}</td> {{-- Vérifie bien le nom du champ dans ta DB --}}
                                    <td>
                                        <form action="{{ url('destroy_user', $user->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce Client ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    @include('admin.js')
</body>
</html>
