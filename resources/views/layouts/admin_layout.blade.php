<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Himbi Market Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom Font Icons CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">

    <!-- Theme stylesheet -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.default.css') }}" id="theme-stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/img/favicon.ico') }}">

    <!-- Custom Styles -->
    @stack('styles')

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        .page-content {
            padding: 20px;
            margin-left: 250px;
            background-color: #1e1e2f;
            min-height: 100vh;
        }

        .header {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1030;
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            overflow-y: auto;
            background-color: #2f3e47;
            padding-top: 60px;
        }

        .navbar {
            padding: 0;
        }

        .navbar .navbar-header .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar .logout {
            position: absolute;
            right: 20px;
            top: 10px;
        }

        .container-fluid {
            padding: 0 30px;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    @include('admin.header')

    {{-- Sidebar --}}
    @include('admin.sidebar')

    {{-- Contenu principal --}}
    <div class="page-content">
        @yield('content')
    </div>

    {{-- JS --}}
    @include('admin.js')

    {{-- Scripts personnalisés --}}
    @stack('scripts')
</body>
</html>
