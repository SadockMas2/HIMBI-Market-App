<!DOCTYPE html>
<html>
<head>
    <base href="/public">
    @include('admin.css')
    <style>
      .form-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: #2c2f33;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.4);
      }
      .form-label { color: white; font-weight: 500; }
      .form-title { text-align: center; color: #f1c40f; margin-bottom: 30px; }
      .ingredients-list { max-height: 400px; overflow-y: auto; padding: 10px; border: 1px solid #444; border-radius: 8px; background-color: #1b1b1b; }
      .ingredients-list div { margin-bottom: 8px; display: flex; align-items: center; gap: 5px; }
      .ingredients-list input[type="number"], .ingredients-list select { width: 80px; }
      .ingredient-name { width: 200px; }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
      <div class="container-fluid">
        <div class="form-container">
          <h3 class="form-title">Modifier le Plat</h3>

          @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

        <form action="{{ url('update_food_post', $food->id) }}" method="POST" enctype="multipart/form-data">
            @csrf


            {{-- Titre --}}
            <div class="mb-3">
              <label class="form-label">Nom du plat</label>
              <input type="text" class="form-control" name="title" value="{{ $food->title }}" required>
            </div>

            {{-- Détails --}}
            <div class="mb-3">
              <label class="form-label">Détails</label>
              <textarea class="form-control" name="details" rows="3" required>{{ $food->detail }}</textarea>
            </div>

            {{-- Prix --}}
            <div class="mb-3">
              <label class="form-label">Prix</label>
              <input type="number" class="form-control" name="price" value="{{ $food->price }}" step="0.01" required>
            </div>

            {{-- Image actuelle --}}
            <div class="mb-3">
              <label class="form-label">Image actuelle</label><br>
              <img src="food_img/{{ $food->image }}" width="150" class="rounded border">
            </div>

            {{-- Changer l'image --}}
            <div class="mb-3">
              <label class="form-label">Changer l'image</label>
              <input type="file" class="form-control" name="image" accept="image/*">
            </div>

            {{-- Ingrédients --}}
            <div class="mb-3">
              <label class="form-label">Ingrédients</label>
              <input type="text" id="ingredientSearch" class="form-control form-control-sm mb-2" placeholder="Rechercher un ingrédient...">
              <div class="ingredients-list">
                @foreach($ingredients as $ingredient)
                  @php
                    $pivot = $food->ingredients->find($ingredient->id)?->pivot;
                  @endphp
                  <div class="ingredient-item">
                    <input type="checkbox" name="ingredients[{{ $ingredient->id }}][selected]" value="1"
                    @if($pivot) checked @endif>

                    <span class="ingredient-name text-white">{{ $ingredient->name }} (Stock: {{ $ingredient->quantity_in_stock }} {{ $ingredient->unit }})</span>

                    <input type="number" name="ingredients[{{ $ingredient->id }}][quantity_required]" 
                           value="{{ $pivot->quantity_required ?? 1 }}" min="0.01" step="0.01" class="form-control form-control-sm" placeholder="Qté">

                    <select name="ingredients[{{ $ingredient->id }}][unit]" class="form-select form-select-sm">
                      @foreach(['kg','g','L','pcs','ml'] as $unit)
                        <option value="{{ $unit }}" @if(($pivot->unit ?? $ingredient->unit) == $unit) selected @endif>{{ $unit }}</option>
                      @endforeach
                    </select>
                  </div>
                @endforeach
              </div>
              <small class="text-muted">Cochez les ingrédients et saisissez la quantité. Utilisez la barre de recherche pour filtrer.</small>
            </div>

            <script>
              const searchInput = document.getElementById('ingredientSearch');
              searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                document.querySelectorAll('.ingredient-item').forEach(item => {
                  item.style.display = item.textContent.toLowerCase().includes(filter) ? 'flex' : 'none';
                });
              });
            </script>

            {{-- Bouton --}}
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-warning px-5">Mettre à jour</button>
            </div>
        </form>

        </div>
      </div>
    </div>

    @include('admin.js')
</body>
</html>
