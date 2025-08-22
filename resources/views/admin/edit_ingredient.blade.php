<!DOCTYPE html>
<html>
  <head> 
    <base href="/public">
    @include('admin.css')

    <style>
      .form-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background-color: #2c2f33;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.4);
      }

      .form-label {
        color: white;
        font-weight: 500;
      }

      .form-title {
        text-align: center;
        color: #f1c40f;
        margin-bottom: 30px;
      }
    </style>
  </head>
  <body>

    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
      <div class="container-fluid">

        <div class="form-container">
          <h3 class="form-title">Modifier l'Ingrédient</h3>
          <form action="{{ route('admin.ingredients.update_single', $ingredient->id) }}" method="POST">
              @csrf
              @method('PUT')
            
                       {{-- important pour la méthode PUT --}}

            <div class="mb-3">
              <label class="form-label">Nom de l'ingrédient</label>
              <input type="text" class="form-control" name="name" value="{{ $ingredient->name }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Quantité disponible</label>
              <input type="number" class="form-control" name="quantity_in_stock" value="{{ $ingredient->quantity_in_stock }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Unité</label>
                <select name="unit" class="form-select" required>
                    @php
                        $units = ['pcs', 'kg', 'g', 'L', 'ml'];
                    @endphp
                    @foreach($units as $unit)
                        <option value="{{ $unit }}" {{ $ingredient->unit == $unit ? 'selected' : '' }}>
                            {{ $unit }}
                        </option>
                    @endforeach
                </select>
            </div>


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
