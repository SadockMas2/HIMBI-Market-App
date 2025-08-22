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
      .form-label { color: white; font-weight: 500; }
      .form-title { text-align: center; color: #2ecc71; margin-bottom: 30px; }
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
      <div class="container-fluid">
        <div class="form-container">
          <h3 class="form-title">Ajouter un Ingrédient</h3>

         <form action="{{ url('store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom de l'ingrédient</label>
                <input type="text" name="name" class="form-control" placeholder="Ex: Tomates" required>
            </div>

            <div class="form-group mt-3">
                <label for="quantity_in_stock">Quantité disponible</label>
                <input type="number" name="quantity_in_stock" step="0.01" class="form-control" placeholder="Ex: 100" required>
            </div>

            <div class="form-group mt-3">
                <label for="unit">Unité</label>
                <select name="unit" class="form-control" required>
                    <option value="pcs">Pièces</option>
                    <option value="kg">Kilogrammes</option>
                    <option value="mg">Milligrammes</option>
                    <option value="g">Grammes</option>
                    <option value="L">Litres</option>
                    <option value="ml">Millilitres</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">Ajouter</button>
        </form>

        </div>
      </div>
    </div>

    @include('admin.js')
  </body>
</html>
