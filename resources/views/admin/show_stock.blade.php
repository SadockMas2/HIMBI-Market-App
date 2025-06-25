<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Stock des Plats</title>

  @include('admin.css')

  <style>
    body {
      background-color: #260814;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .page-content {
      max-width: 900px;
      margin: 40px auto;
      padding: 30px 20px;
      background: rgb(57, 56, 56);
      border-radius: 12px;
      box-shadow: 0 6px 20px rgb(0 0 0 / 0.1);
    }

    h2 {
      font-weight: 700;
      margin-bottom: 30px;
      color: #d1d7dc;
      text-align: center;
      font-size: 30px;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 12px;
      font-size: 16px;
    }

    thead th {
      background-color: #061b29;
      color: rgb(70, 63, 204);
      font-weight: 700;
      padding: 15px;
      border-radius: 10px 10px 0 0;
      text-align: center;
      user-select: none;
    }

    tbody tr {
      background-color: #00080c;
      color: white;
      font-weight: 600;
      transition: background-color 0.3s ease;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgb(0 0 0 / 0.08);
    }

    tbody tr:hover {
      background-color: #1c5980;
    }

    tbody td {
      padding: 12px 15px;
      text-align: center;
      border-radius: 0 0 8px 8px;
      vertical-align: middle;
    }

    form {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }

    form input[type="number"] {
      max-width: 100px;
      padding: 6px 10px;
      border-radius: 6px;
      border: 1.8px solid #b0c4de;
      font-size: 16px;
      transition: border-color 0.3s ease;
    }

    form input[type="number"]:focus {
      border-color: #3498db;
      outline: none;
      box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
    }

    form button {
      background-color: #3498db;
      border: none;
      color: white;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    form button:hover {
      background-color: #2868c7;
    }

    @media (max-width: 480px) {
      .page-content {
        padding: 20px 10px;
      }

      form {
        flex-direction: column;
        gap: 12px;
      }

      form input[type="number"] {
        max-width: 100%;
        width: 100%;
      }

      form button {
        width: 100%;
      }
    }

  </style>
</head>
<body>

  @include('admin.header')
  @include('admin.sidebar')

  <div class="page-content">
    <h2>Stock des Plats</h2>

    @if(session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <table>
      <thead>
        <tr>
          <th>Nom du plat</th>
          <th>Quantité en stock</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($food as $plat)
          <tr>
            <td>{{ $plat->title }}</td>
            <td>{{ $plat->stock }}</td>
            <td>
              <form method="POST" action="{{ url('update_stock/'.$plat->id) }}">
                @csrf
                <input
                  type="number"
                  name="stock"
                  min="0"
                  value="{{ $plat->stock }}"
                  required
                  aria-label="Quantité en stock pour {{ $plat->title }}"
                >
                <button type="submit">Mettre à jour</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>

  @include('admin.js')

</body>
</html>
