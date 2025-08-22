<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cuisine - Plats à Préparer</title>

   
   
    @include('admin.css')

    <style>

        title {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2ddd15
        }

    .page-content {
      max-width: 1100px;
      margin: 40px auto;
      margin-left: 350px;
      padding: 30px 40px;
      background: rgb(51, 29, 29);
      border-radius: 12px;
      box-shadow: 0 6px 20px rgb(0 0 0 / 0.1);
    }

     .table-container {
        max-width: 95%;
        margin-left: 450px;
        margin: 40px auto;
        background-color: #2c2f33;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
      }
        body {
            background-color: #260814;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin-left: 300px;
            margin-top: 150px;
            /* margin: 40px auto; */
            padding: 20px;
        }

        .card {
            background-color: #1b1b1b;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.5);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-grow: 1;
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            color: #f5f5f5;
        }

        .stock {
            font-weight: 600;
            color: #8ac6f2;
        }

        .ingredients {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
            font-size: 14px;
            color: #ccc;
        }

        .ingredients li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        form {
            display: flex;
            gap: 10px;
            margin-top: auto;
            flex-wrap: wrap;
        }

        form input[type="number"] {
            flex: 1;
            min-width: 60px;
            padding: 6px 10px;
            border-radius: 8px;
            border: 1.5px solid #b0c4de;
            font-size: 14px;
        }

        form button {
            background-color: #3498db;
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #2868c7;
        }

        @media (max-width: 480px) {
            .card img { height: 150px; }
            .card-title { font-size: 18px; }
            .ingredients { font-size: 12px; }
            form { flex-direction: column; }
        }
    </style>
</head>
<body>

        @include('admin.header')
        @include('admin.sidebar')

        
  
        <div class="cards-container">
            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            

            @foreach($foods as $food)
            <div class="card">
                <img src="{{ asset('food_img/' . $food->image) }}" alt="{{ $food->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $food->title }}</h5>
                    <p class="stock"><strong>Stock disponible :</strong> {{ $food ->stock ?? 0 }}</p>

                    <ul class="ingredients">
                        @foreach($food->ingredients as $ingredient)
                            @php
                                $convertToBase = function($quantity, $unit) {
                                    $unit = strtolower($unit);
                                    switch ($unit) {
                                        case 'kg': return $quantity * 1000;
                                        case 'g': return $quantity;
                                        case 'l': return $quantity * 1000;
                                        case 'ml': return $quantity;
                                        default: return $quantity;
                                    }
                                };
                                $stockBase = $convertToBase($ingredient->quantity_in_stock, $ingredient->unit);
                                $requiredBase = $convertToBase($ingredient->pivot->quantity_required, $ingredient->pivot->unit);
                                $suffisant = $stockBase >= $requiredBase;
                            @endphp
                            <li>
                                {{ $ingredient->name }} : {{ $ingredient->quantity_in_stock }} {{ $ingredient->unit }}
                                (Requis : {{ $ingredient->pivot->quantity_required }} {{ $ingredient->pivot->unit }})
                                <span style="color: {{ $suffisant ? '#2ecc71' : '#e74c3c' }}">
                                    {{ $suffisant ? 'OK' : 'Stock insuffisant' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    <form action="{{ route('prepareDish', $food->id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" min="1" value="1" placeholder="Quantité à préparer">
                        <button type="submit">Préparer</button>
                    </form>

                </div>
            </div>
            @endforeach
        </div>

@include('admin.js')
</body>
</html>
