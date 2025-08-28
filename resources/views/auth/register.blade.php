<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: url('/images_sections/connexion.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        /* Overlay pour effet foncé */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }

        /* Carte principale */
        .auth-card {
            position: relative;
            z-index: 10;
            width: 95%;
            max-width: 420px;
            margin: auto;
            margin-top: 5vh;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            padding: 30px 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            color: #ffce54;
            text-shadow: 0 2px 6px rgba(0,0,0,0.5);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #f1f1f1;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1rem;
            margin-bottom: 18px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #ffce54;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 6px #ffce54;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #ffce54, #ffb300);
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #222;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 193, 7, 0.7);
        }

        .already-registered {
            text-align: center;
            margin-top: 15px;
            font-size: 0.95rem;
            color: #ddd;
        }

        .already-registered a {
            color: #ffce54;
            text-decoration: none;
            font-weight: 600;
        }

        .already-registered a:hover {
            text-decoration: underline;
        }

        .terms {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            margin-bottom: 15px;
            color: #ddd;
        }

        .terms a {
            color: #ffce54;
            text-decoration: none;
            font-weight: 600;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .validation-errors {
            background: rgba(220, 38, 38, 0.85);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-card {
                padding: 20px;
                margin-top: 10vh;
            }
            h1 {
                font-size: 1.7rem;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                width: 90%;
                padding: 18px;
            }
            h1 {
                font-size: 1.5rem;
            }
            button {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>

    <div class="overlay"></div>

    <div class="auth-card">
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
                <a href="{{ ('/') }}">Déjà inscrit ? Connectez-vous</a>
            </div>
        </form>
    </div>
</x-guest-layout>
