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
          <h3 class="form-title">Ajouter un Nouveau Plat</h3>

          <form action="{{ url('upload_food') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label class="form-label" for="title">Nom du Plat</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Ex: Brochettes de poulet" required>
            </div>

            <div class="mb-3">
              <label class="form-label" for="details">Détails du Plat</label>
              <textarea class="form-control" id="details" name="details" rows="3" placeholder="Ex: Accompagné de frites et sauce maison" required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label" for="price">Prix (USD)</label>
              <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Ex: 7.50" required>
            </div>

            <div class="mb-3">
              <label class="form-label" for="img">Image du Plat</label>
              <input class="form-control" type="file" id="img" name="img" accept="image/*" required>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-warning px-5">Ajouter le Plat</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    @include('admin.js')
  </body>
</html>
