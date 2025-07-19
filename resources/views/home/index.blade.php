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


    @yield('content') {{-- 🟡 C’est ici que le contenu de my_cart sera injecté --}}

    @include('home.header')
     @include('home.gallary')
    @include('home.book')
    @include('home.blog')
    @include('home.about')
    @include('home.footer')
 
</body>
</html>

