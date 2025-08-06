<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e1e2f, #3c3c5f);
            color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 60px auto;
            padding: 30px;
            background-color: #2d2d45;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            color: #fff;
        }

        label {
            display: block;
            margin-bottom: 5px;
            margin-top: 15px;
            font-weight: bold;
            color: #ddd;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: none;
            background-color: #44445e;
            color: #fff;
            font-size: 14px;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .success {
            background-color: #28a745;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            color: white;
        }

        .error {
            background-color: #dc3545;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mon Profil</h1>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
    @csrf

    <label for="name">Nom</label>
    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>

    <label for="email">Email</label>
    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>

    <label for="phone">Téléphone</label>
    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}">

    <label for="address">Adresse</label>
    <textarea name="address">{{ old('address', auth()->user()->address) }}</textarea>

    <hr style="margin: 20px 0; border-color: #555;">

    <label for="current_password">Mot de passe actuel</label>
    <input type="password" name="current_password" autocomplete="current-password">

    <label for="password">Nouveau mot de passe</label>
    <input type="password" name="password" autocomplete="new-password">

    <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
    <input type="password" name="password_confirmation" autocomplete="new-password">

    <button type="submit">Mettre à jour</button>

 

<a href="{{ url('/') }}" style="
    display: inline-block;
    margin-top: 15px;
    text-align: center;
    width: 100%;
    padding: 12px;
    background-color: #6c757d;
    border-radius: 6px;
    color: white;
    text-decoration: none;
    font-size: 16px;
    transition: background-color 0.3s ease;
">Retour</a>

</form>

    </div>
</body>
</html>
