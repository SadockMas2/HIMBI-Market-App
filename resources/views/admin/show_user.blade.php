<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style>
      .user-container {
        max-width: 95%;
        margin: 40px auto;
        background-color: #2c2f33;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.3);
      }

      .user-table thead {
        background-color: skyblue;
        color: white;
      }

      .user-table td {
        color: white;
        vertical-align: middle;
      }

      h2 {
        color: #f1c40f;
        text-align: center;
        margin-bottom: 25px;
      }

      .user-table {
        width: 100%;
      }
    </style>
  </head>

  <body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
      <div class="container-fluid">
        <div class="user-container">

          <h2>Liste des utilisateurs</h2>

          <table class="table table-bordered text-center user-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Rôle</th>
                <th>Email</th>
                <th>Adresse</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ ucfirst($user->usertype) }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->adress }}</td> {{-- Vérifie bien le nom de la colonne : "adress" ou "address" --}}
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
