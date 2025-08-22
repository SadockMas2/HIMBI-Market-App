@extends('serveur.index')

<style>
  body {
    background-color: #260814;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    color: #623939;
  }

  .page-content {
    max-width: 1000px;
    margin-left: 50px;
    /* margin: 40px auto 40px 270px; Décalage pour le sidebar */
    padding: 25px 20px;
    background: #1c1b1b;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }

  h2 {
    font-weight: 700;
    margin-bottom: 25px;
    color: #d4dee6;
    text-align: center;
    font-size: 26px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 15px;
    background-color: #1a1a1a;
    border-radius: 10px;
    overflow: hidden;
  }

  thead th {
    background-color: #061b29;
    color: #49a6e9;
    font-weight: 600;
    padding: 10px;
    text-align: center;
  }

  tbody td {
    padding: 8px 10px;
    text-align: center;
    color: #5b3737;
    border-bottom: 1px solid #444;
  }

  tr:hover {
    background-color: #2e2e2e;
  }

  @media (max-width: 768px) {
    .page-content {
      margin: 20px 10px;
    }

    table {
      font-size: 13px;
    }

    thead {
      display: none;
    }

    tbody td {
      display: block;
      text-align: right;
      padding: 8px;
      position: relative;
    }

    tbody td::before {
      content: attr(data-label);
      position: absolute;
      left: 10px;
      text-align: left;
      font-weight: bold;
      color: #aaa;
    }

    tbody tr {
      margin-bottom: 10px;
      display: block;
      border: 1px solid #333;
      border-radius: 8px;
      padding: 8px;
    }
  }
</style>

@section('content')
<div class="page-content">
    <h2>Réservations des clients</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Téléphone</th>
                <th>Invités</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Table</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($book as $booking)
            <tr>
                <td data-label="Nom">{{ $booking->name }}</td>
                <td data-label="Téléphone">{{ $booking->phone }}</td>
                <td data-label="Invités">{{ $booking->guest }}</td>
                <td data-label="Date">{{ $booking->date }}</td>
                <td data-label="Heure">{{ $booking->time }}</td>
                <td data-label="Table">{{ $booking->table_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
