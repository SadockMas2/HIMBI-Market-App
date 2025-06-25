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
          <h3 class="form-title">Modifier le Plat</h3>

          <form action="{{ url('edit_food', $food->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label class="form-label">Nom du plat</label>
              <input type="text" class="form-control" name="title" value="{{ $food->title }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Détails</label>
              <textarea class="form-control" name="details" rows="3" required>{{ $food->detail }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Prix</label>
              <input type="number" class="form-control" name="price" value="{{ $food->price }}" step="0.01" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Image actuelle</label><br>
              <img src="food_img/{{ $food->image }}" alt="Image du plat" width="150" class="rounded border">
            </div>

            <div class="mb-3">
              <label class="form-label">Changer l'image</label>
              <input type="file" class="form-control" name="image" accept="image/*">
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
