<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cuisine - Préparer les Plats</title>

  @include('admin.css')

  <style>
 

    body { 
      background-color: #2c2f33;
      color: #fff; 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
      margin:0; padding:0; 
    }
    .page-content { 
      max-width: 1100px; 
      margin-top: 60px; /* Hauteur du header */
      margin-left: 340px; /* Largeur de la sidebar */
      padding: 20px;
      background:#2c2f33; 
      border-radius:12px; 
      box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }
    h2 { 
      text-align:center; 
      margin-bottom:30px; 
      color:#f1c40f; 
      font-size:32px; 
      font-weight:700;
    }
    table { 
      width:100%; 
      border-collapse: collapse; 
      table-layout: fixed;
    }
    thead th { 
      background:#061b29; 
      color:#f1c40f; 
      padding:12px; 
      font-weight:700; 
      border-radius:6px 6px 0 0;
    }
    tbody tr { 
      background:#2c2f33; 
      transition:0.3s; 
      border-radius:6px; 
      margin-bottom:5px; 
    }
    tbody tr:hover { 
      background:#34495e; 
    }
    td { 
      padding:12px; 
      text-align:center; 
      vertical-align: middle; 
      word-wrap: break-word;
    }
    .ingredient-list { 
      text-align:left; 
      margin:5px 0; 
      font-size:14px; 
      color:#ccc; 
      max-height: 120px; 
      overflow-y:auto;
    }
    .ingredient-list li { margin-bottom:4px; }
    .ok { color:#2ecc71; font-weight:600; }
    .not-ok { color:#e74c3c; font-weight:600; }
    input[type="number"] { 
      width:70px; 
      padding:5px; 
      border-radius:5px; 
      border:1px solid #b0c4de; 
      text-align:center; 
      background:#1e1e2f; 
      color:#fff;
    }
    button { 
      padding:6px 12px; 
      border:none; 
      border-radius:6px; 
      background:#3498db; 
      color:#fff; 
      cursor:pointer; 
      transition:0.3s;
    }
    button:hover { background:#2980b9; }
    @media(max-width:768px){
      table, thead, tbody, th, td, tr { display:block; width:100%; }
      thead { display:none; }
      tr { margin-bottom:15px; padding:10px; border-radius:10px; }
      td { text-align:left; padding:10px; position:relative; }
      td::before { content: attr(data-label); font-weight:bold; display:block; margin-bottom:4px; color:#f1c40f; }
      .ingredient-list { max-height:100px; overflow-y:auto; }
    }
  </style>
</head>
<body>

@include('admin.header')
@include('admin.sidebar')

<div class="page-content">
  <h2>Kitchen - Préparer les Plats</h2>

  @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger text-center">{{ session('error') }}</div>
  @endif

  <table>
    <thead>
      <tr>
        <th>Plat</th>
        <th>Quantité en Stock </th>
        <th>Ingrédients requis</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($foods as $plat)
      <tr>
        <td data-label="Plat">{{ $plat->title }}</td>
        <td data-label="Stock préparé">{{ $plat->stock ?? 0 }}</td>
      
        <td data-label="Ingrédients requis" class="ingredient-list">
          <ul>
            @foreach($plat->ingredients as $ingredient)
              @php
                $unit = strtolower($ingredient->unit);
                $required = $ingredient->pivot->quantity_required;
                $stock = $ingredient->quantity_in_stock;
                $suffisant = ($unit=='kg'||$unit=='l') ? ($stock*1000 >= $required) : ($stock >= $required);
              @endphp
              <li>
                {{ $ingredient->name }} : {{ $stock }} {{ $ingredient->unit }} (Requis : {{ $required }} {{ $ingredient->pivot->unit }})
                <span class="{{ $suffisant ? 'ok' : 'not-ok' }}">{{ $suffisant ? 'OK' : 'Stock insuffisant' }}</span>
              </li>
            @endforeach
          </ul>
        </td>
        <td data-label="Action">
          @if(strtolower($plat->detail) === 'boisson')
            <!-- Boissons : juste mise à jour -->
            <form action="{{ route('updateDrinkStock', $plat->id) }}" method="POST">
              @csrf
              <input type="number" name="stock" min="0" value="{{ $plat->stock ?? 0 }}" required>
              <button type="submit">Mettre à jour</button>
            </form>
          @else
            <!-- Plats classiques : préparer -->
            <form action="{{ route('prepareDish', $plat->id) }}" method="POST">
              @csrf
              <input type="number" name="quantity" min="1" value="1" required>
              <button type="submit">Préparer</button>
            </form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@include('admin.js')
</body>
</html>
