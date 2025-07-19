<!DOCTYPE html>
<html lang="fr">
<head>
    @include('home.css')
</head>
<body style="background-color: #1a1a1a; color: white;">

    @include('home.header')

    <div class="main-content">
        @yield('content')
    </div>

    @include('home.footer')

</body>
</html>
