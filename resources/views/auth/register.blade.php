<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('/images_sections/connexion.jpg') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden; /* plus de scroll */
            color: #fff;
        }

        .overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        .auth-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            width: 100%;
            max-width: 360px;
            background: rgba(30, 30, 30, 0.85);
            border-radius: 20px;
            padding: 30px 25px 35px 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.7);
            overflow-y: auto;
            max-height: 90vh;
        }

        h1 {
            font-weight: 700;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 15px;
            color: #ffc107;
            letter-spacing: 1.3px;
            text-shadow: 0 0 8px rgba(255, 193, 7, 0.9);
        }

        label {
            font-weight: 500;
            font-size: 1rem;
            display: block;
            margin-bottom: 6px;
            color: #ddd;
            user-select: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 16px;
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.12);
            color: #eee;
            font-size: 1.05rem;
            margin-bottom: 22px;
            box-shadow:
                inset 2px 2px 6px rgba(255,255,255,0.15),
                inset -2px -2px 6px rgba(0,0,0,0.7);
            transition: background 0.25s ease, box-shadow 0.25s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.25);
            outline: none;
            box-shadow: 0 0 12px #ffc107;
            color: #fff;
        }

        button {
            background: linear-gradient(90deg, #ffc107, #ffca28);
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.15rem;
            cursor: pointer;
            color: #222;
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.6);
            transition: background 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
        }

        button:hover {
            background: linear-gradient(90deg, #ffb300, #ffa000);
            box-shadow: 0 8px 30px rgba(255, 167, 0, 0.9);
        }

        .already-registered {
            margin-top: 20px;
            font-size: 0.95rem;
            text-align: center;
            color: #ddd;
            user-select: none;
        }

        .already-registered a {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.25s ease;
        }

        .already-registered a:hover {
            color: #ffca28;
            text-decoration: underline;
        }

        .terms {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: #ddd;
            margin-bottom: 22px;
            user-select: none;
        }

        .terms a {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
        }

        .terms a:hover {
            text-decoration: underline;
            color: #ffca28;
        }

        .validation-errors {
            background-color: rgba(255, 50, 50, 0.85);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 0 10px rgba(255, 50, 50, 0.8);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-card {
                width: 90%;
                padding: 25px 15px 30px 15px;
            }
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>

    <div class="overlay"></div>

    <div class="auth-card">
        <div class="auth-card-logo">
            <x-authentication-card-logo />
        </div>

        <h1>Créer un compte</h1>

        <x-validation-errors class="validation-errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Nom complet</label>
                <x-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div>
                <label for="email">Adresse e-mail</label>
                <x-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div>
                <label for="phone">Téléphone</label>
                <x-input id="phone" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
            </div>

            <div>
                <label for="adress">Adresse</label>
                <x-input id="adress" type="text" name="adress" :value="old('adress')" required autocomplete="street-address" />
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <x-input id="password" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div>
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <x-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="terms">
                    <x-checkbox name="terms" id="terms" required />
                    <label for="terms" class="ms-2">
                        {!! __('J\'accepte les :terms_of_service et la :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'">Conditions d\'utilisation</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'">Politique de confidentialité</a>',
                        ]) !!}
                    </label>
                </div>
            @endif

            <button type="submit">S'inscrire</button>

            <div class="already-registered">
                <a href="{{ route('login') }}">Déjà inscrit ? Connectez-vous</a>
            </div>
        </form>
    </div>
</x-guest-layout>
