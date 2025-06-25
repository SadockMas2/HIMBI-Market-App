<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style>
      .table-container {
        max-width: 95%;
        margin: 40px auto;
        background-color: #2c2f33;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
      }

      .table th, .table td {
        vertical-align: middle;
      }

      .table thead {
        background-color: skyblue;
        color: white;
      }

      .table td {
        color: white;
      }

      .table img {
        border-radius: 8px;
        border: 1px solid #ddd;
      }

      h1 {
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
        <div class="table-container">
          <h1>Nos Plats</h1>

          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Détails</th>
                <th>Prix</th>
                <th>Image</th>
                <th>Supprimer</th>
                <th>Modifier</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $item)
                <tr>
                  <td>{{ $item->title }}</td>
                  <td>{{ $item->detail }}</td>
                  <td>${{ number_format((float) $item->price, 2) }}</td>

                  <td>
                    <img width="100" src="{{ asset('food_img/'.$item->image) }}" alt="{{ $item->title }}">
                  </td>
                  <td>
                    <a class="btn btn-danger btn-sm" 
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?')"
                       href="{{ url('delete_food', $item->id) }}">
                      Supprimer
                    </a>
                  </td>
                  <td>
                    <a class="btn btn-warning btn-sm" href="{{ url('update_food', $item->id) }}">
                      Modifier
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>

    @include('admin.js')
  </body>
</html>
