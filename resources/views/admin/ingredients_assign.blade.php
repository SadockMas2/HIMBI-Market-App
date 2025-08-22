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

   @section('content')
<div class="page-content">
    <h2 class="text-center mb-4">Affecter des ingrédients à {{ $food->title }}</h2>

    <form action="{{ route('food.ingredients.store', $food->id) }}" method="POST">
        @csrf

        <div id="ingredients-container">
            <div class="ingredient-row mb-3">
                <select name="ingredients[0][id]" class="form-control" required>
                    <option value="">-- Choisir un ingrédient --</option>
                    @foreach($ingredients as $ing)
                        <option value="{{ $ing->id }}">{{ $ing->name }} (Stock: {{ $ing->stock }})</option>
                    @endforeach
                </select>

                <input type="number" name="ingredients[0][quantity_required]" class="form-control" placeholder="Quantité requise" step="0.01" required>
                <input type="text" name="ingredients[0][unit]" class="form-control" placeholder="Unité (g, ml, pièces...)" required>
            </div>
        </div>

        <button type="button" id="add-ingredient" class="btn btn-secondary">+ Ajouter un ingrédient</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<script>
    let index = 1;
    document.getElementById('add-ingredient').addEventListener('click', function() {
        const container = document.getElementById('ingredients-container');
        const row = document.createElement('div');
        row.classList.add('ingredient-row', 'mb-3');
        row.innerHTML = `
            <select name="ingredients[${index}][id]" class="form-control" required>
                <option value="">-- Choisir un ingrédient --</option>
                @foreach($ingredients as $ing)
                    <option value="{{ $ing->id }}">{{ $ing->name }} (Stock: {{ $ing->stock }})</option>
                @endforeach
            </select>

            <input type="number" name="ingredients[${index}][quantity_required]" class="form-control" placeholder="Quantité requise" step="0.01" required>
            <input type="text" name="ingredients[${index}][unit]" class="form-control" placeholder="Unité (g, ml, pièces...)" required>
        `;
        container.appendChild(row);
        index++;
    });
</script>
@endsection
    @include('admin.js')
</body>
</html>
