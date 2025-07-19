<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue sur Himbi Market</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('/images_sections/connexion.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 0;
        }

        .content {
            position: relative;
            z-index: 1;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(255,255,255,0.3);
            width: 90%;
            max-width: 400px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #ffc107;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"],
        input[type="password"] {
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
        }

        button {
            background-color: #ffc107;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #e0a800;
        }

        .register-link {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #ccc;
        }

        .register-link a {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Bienvenue à Himbi Market</h1>
        <p>Connectez-vous pour commander ou réserver</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Adresse email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Connexion</button>
        </form>

        <div class="register-link">
            Pas encore inscrit ?
            <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>
</body>
</html>
