<!DOCTYPE html>
<html>
<head> 
    @include('admin.css')

    <style>
        table {
            border: 1px solid skyblue;
            margin: 30px auto;
            width: 90%;
            max-width: 900px;
            border-collapse: collapse;
            background-color: #34495e;
            color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid skyblue;
            text-align: center;
        }

        th {
            background-color: skyblue;
            color: #fff;
            font-weight: bold;
        }

        tr:hover {
            background-color: #3d566e;
        }

        .alert-success {
            max-width: 900px;
            margin: 20px auto;
            padding: 12px;
            background-color: #2ecc71;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
        }

        form select {
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
        }

        form button {
            padding: 5px 12px;
            background-color: #2980b9;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        form button:hover {
            background-color: #1c5980;
        }

        .btn-delete {
            padding: 5px 12px;
            background-color: #e74c3c;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                <h1 style="text-align:center; margin-top: 20px;">Gestion des Tables</h1>

                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom de la Table</th>
                            <th>Capacité</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tables as $table)
                            <tr>
                                <td>{{ $table->id }}</td>
                                <td>{{ $table->nom_table }}</td>
                                <td>{{ $table->capacite }} personnes</td>
                                <td>
                                    @if($table->nom_table !== 'Commande externe')
                                        <form action="{{ url('/update_table_status', $table->id) }}" method="POST" style="display: inline-flex; align-items: center; gap: 10px;">
                                            @csrf
                                            @method('PUT')
                                            <select name="statut" required>
                                                <option value="Disponible" {{ strtolower($table->statut) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="Réservée" {{ strtolower($table->statut) == 'réservée' ? 'selected' : '' }}>Réservée</option>
                                                <option value="Occupée" {{ strtolower($table->statut) == 'occupée' ? 'selected' : '' }}>Occupée</option>
                                            </select>
                                            <button type="submit">Modifier</button>
                                        </form>
                                    @else
                                        <span style="color: #aaa;">Action désactivée</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Supprimer --}}
                                    @if($table->nom_table !== 'Commande externe')
                                        <form action="{{ url('/delete_table', $table->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette table ?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Supprimer</button>
                                        </form>
                                    @endif

                @if($table->nom_table == 'Commande externe')
                    <p class="text-success">Table partagée entre tous les serveurs</p>
                @else
                    {{-- Assigner un serveur --}}
                    <form action="{{ url('assign_serveur/'.$table->id) }}" method="POST" style="margin-top: 5px;">
                        @csrf
                        <select name="serveur_id" class="form-control">
                            <option value="">-- Assigner un serveur --</option>
                            @foreach($serveurs as $serveur)
                                <option value="{{ $serveur->id }}" {{ $table->serveur_id == $serveur->id ? 'selected' : '' }}>
                                    {{ $serveur->name }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary mt-1">Assigner</button>
                    </form>
                @endif

                                    {{-- Libérer --}}
                                    @if(in_array(strtolower($table->statut), ['réservée', 'occupée']) && $table->nom_table !== 'Commande externe')
                                        <form action="{{ url('/liberer_table', $table->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn" style="background-color: #27ae60; color: white; margin-top: 5px;">
                                                Libérer
                                            </button>
                                        </form>
                                    @endif
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
