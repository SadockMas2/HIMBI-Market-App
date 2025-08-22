<!DOCTYPE html>
<html>
  <head> 
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
          <h3 class="form-title">Affecter des ingrédients au plat : {{ $food->title }}</h3>

          {{-- message succès / erreur --}}
          @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
          @endif

          {{-- formulaire d’affectation --}}
          <form action="{{ route('food.ingredients.store', $food->id) }}" method="POST">
              @csrf

              <div class="mb-3">
                <label class="form-label">Sélectionner les ingrédients</label>
                <select name="ingredients[]" class="form-select" multiple required>
                  @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}" 
                      @if($food->ingredients->contains($ingredient->id)) selected @endif>
                      {{ $ingredient->name }}
                    </option>
                  @endforeach
                </select>
                <small class="text-muted">Maintenez CTRL (ou CMD sur Mac) pour sélectionner plusieurs ingrédients</small>
              </div>

              <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">Enregistrer</button>
                <a href="{{ url('foods') }}" class="btn btn-secondary px-5">Retour</a>
              </div>
          </form>

        </div>

      </div>
    </div>

    @include('admin.js')
  </body>
</html>
