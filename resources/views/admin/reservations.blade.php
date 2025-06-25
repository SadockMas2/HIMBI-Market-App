<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Réservations</title>

  @include('admin.css')

  <style>
    body {
      background-color: #000308;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .page-content {
      max-width: 1100px;
      margin: 40px auto;
      padding: 30px 40px;
      background: rgb(51, 29, 29);
      border-radius: 12px;
      box-shadow: 0 6px 20px rgb(0 0 0 / 0.1);
    }

    h1 {
      text-align: center;
      font-weight: 700;
      margin-bottom: 40px;
      color: #d5dde5;
      font-size: 32px;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 12px;
      font-size: 16px;
    }

    thead th {
      background-color: #3498db;
      color: white;
      font-weight: 700;
      padding: 18px 15px;
      border-radius: 10px 10px 0 0;
      text-align: center;
      user-select: none;
    }

    tbody tr {
      background-color: #2980b9;
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
      padding: 14px 15px;
      text-align: center;
      border-radius: 0 0 8px 8px;
      user-select: text;
    }
  </style>
</head>
<body>

  @include('admin.header')
  @include('admin.sidebar')

  <div class="page-content">
    <h1>Réservations</h1>

    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Numéro Tel</th>
          <th>Nombre d'invités</th>
          <th>Date</th>
          <th>Heure</th>
          <th>Table-ID</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($book as $reservation)
          <tr>
            <td>{{ $reservation->name }}</td>
            <td>{{ $reservation->phone }}</td>
            <td>{{ $reservation->guest }}</td>
            <td>{{ $reservation->date }}</td>
            <td>{{ $reservation->time }}</td>
            <td>{{ $reservation->table_id }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @include('admin.js')
</body>
</html>
