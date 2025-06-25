<!DOCTYPE html>
<html lang="fr">
<head>
    @include('serveur.css')
    <title>Serveur - Tableau de Bord</title>
</head>
<body class="bg-dark text-white">
    
    @include('serveur.header')
    
    <div class="d-flex">
        @include('serveur.sidebar')

        <div class="content p-4" style="width: 100%;">
            @yield('content')
        </div>
    </div>

</body>
</html>
