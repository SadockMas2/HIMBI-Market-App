<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        body {
            background-color: #1e1e2f;
            color: #fff;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: #2c2f33;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }
        h3 {
            text-align: center;
            color: #f1c40f;
            margin-bottom: 20px;
        }
        .table thead th {
            background: #34495e;
            color: #f1c40f;
        }
        .table td, .table th { color: #fff; }
        .table-hover tbody tr:hover { background-color: #3e444e; }
        .btn-warning { background-color: #f39c12; border: none; }
        .btn-danger { background-color: #e74c3c; border: none; }
        .btn-sm { padding: 3px 8px; font-size: 0.875rem; }
        .ingredient-form { margin-top: 30px; }
        .ingredient-item { margin-bottom: 10px; }
        .ingredient-item label { margin-left: 8px; }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="container">
            <h3>Liste des Ingrédients</h3>

            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <!-- Table de tous les ingrédients -->
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Quantité en stock</th>
                        <th>Unité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient->id }}</td>
                            <td>{{ $ingredient->name }}</td>
                            <td>{{ $ingredient->quantity_in_stock }}</td>
                            <td>{{ $ingredient->unit }}</td>
                            <td>
                          
                                <a href="{{ route('admin.ingredients.edit', $ingredient->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <a href="{{ route('admin.ingredients.delete', $ingredient->id) }}" onclick="return confirm('Supprimer cet ingrédient ?')" class="btn btn-sm btn-danger">Supprimer</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @isset($food)
            <!-- Formulaire pour associer des ingrédients au plat -->
         <div class="ingredient-form">
            <h3>Associer des ingrédients au plat : {{ $food->title }}</h3>
            <form action="{{ route('admin.ingredients.update', $food->id) }}" method="POST">
                @csrf
                @foreach($ingredients as $ingredient)
                    <div>
                        <input type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}"
                            {{ in_array($ingredient->id, $selected) ? 'checked' : '' }}>
                        {{ $ingredient->name }} ({{ $ingredient->quantity_in_stock }} {{ $ingredient->unit }})
                    </div>
                @endforeach
                <button type="submit">Mettre à jour</button>
            </form>
        </div>

            @endisset
        </div>
    </div>

    @include('admin.js')
</body>
</html>
