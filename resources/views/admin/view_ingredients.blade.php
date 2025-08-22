<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        .form-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: #2c2f33;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }
        .form-title {
            text-align: center;
            color: #f1c40f;
            margin-bottom: 30px;
        }
        .ingredient-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #444;
        }
        .ingredient-item label {
            color: white;
            font-weight: 500;
            margin-left: 10px;
        }
        .ingredient-list {
            max-height: 400px;
            overflow-y: auto;
        }
        .btn-submit {
            display: block;
            margin: 20px auto 0 auto;
            padding: 10px 30px;
            background-color: #f1c40f;
            color: #2c2f33;
            border: none;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #d4ac0d;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="container-fluid">
            <div class="form-container">
                <h3 class="form-title">
                    Associer des ingrédients au plat : 
                    <span class="text-warning">{{ $food->title }}</span>
                </h3>

                <form action="{{ route('admin.ingredients.update', $food->id) }}" method="POST">
                    @csrf

                    <div class="ingredient-list">
                        @foreach($ingredients as $ingredient)
                            <div class="ingredient-item">
                                <div>
                                    <input 
                                        type="checkbox" 
                                        id="ingredient_{{ $ingredient->id }}" 
                                        name="ingredients[]" 
                                        value="{{ $ingredient->id }}"
                                        {{ in_array($ingredient->id, $selected) ? 'checked' : '' }}
                                    >
                                    <label for="ingredient_{{ $ingredient->id }}">
                                        {{ $ingredient->name }} ({{ $ingredient->quantity_in_stock }} {{ $ingredient->unit }})
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn-submit">Mettre à jour les ingrédients</button>
                </form>
            </div>
        </div>
    </div>

    @include('admin.js')
</body>
</html>
