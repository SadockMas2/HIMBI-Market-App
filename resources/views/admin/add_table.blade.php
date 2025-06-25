<!DOCTYPE html>
<html>
<head> 
    @include('admin.css')

    <style>
        .form-container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #2c3e50;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            color: white;
        }

        .form-container h2 {
            text-align: center;
            color: #f1c40f;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
        }

        input, select {
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        button {
            background-color: #f39c12;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #d35400;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <div class="form-container">
                    <h2>Ajouter une table</h2>

                    <form method="POST" action="{{ url('add_table') }}">
                        @csrf

                        <div class="form-group">
                            <label for="nom_table">Nom de la table</label>
                            <input type="text" id="nom_table" name="nom_table" placeholder="Ex: A1" required>
                        </div>

                        <div class="form-group">
                            <label for="capacite">Capacité</label>
                            <input type="number" id="capacite" name="capacite" placeholder="Ex: 4" required>
                        </div>

                        <div class="form-group">
                            <label for="statut">Statut</label>
                            <select id="statut" name="statut" required>
                                <option value="disponible">Disponible</option>
                                <option value="occupée">Occupée</option>
                            </select>
                        </div>

                        <button type="submit">Ajouter la table</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @include('admin.js')
</body>
</html>
