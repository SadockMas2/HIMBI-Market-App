<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique du Stock</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Historique du Stock</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Plat</th>
                <th>Ingrédient</th>
                <th>Type</th>
                <th>Quantité</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockHistories as $history)
                <tr>
                    <td>{{ $history->id }}</td>
                    <td>{{ $history->food->title ?? '-' }}</td>
                    <td>{{ $history->ingredient->name ?? '-' }}</td>
                    <td>{{ ucfirst($history->type) }}</td>
                    <td>{{ $history->quantity }}</td>
                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
