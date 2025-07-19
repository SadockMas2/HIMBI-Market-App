@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    @include('home.css')
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

    {{-- 🟡 Le contenu principal sera injecté ici (comme my_cart, home, etc.) --}}
    @yield('content')

    {{-- 🟢 Afficher ces sections seulement si l'utilisateur est connecté --}}
    @auth
        @include('home.header')
        @include('home.gallary')
        @include('home.book')
        @include('home.blog')
        @include('home.about')
    @endauth

    {{-- Footer peut rester visible ou être aussi conditionné --}}
    @include('home.footer')
</body>
</html>
