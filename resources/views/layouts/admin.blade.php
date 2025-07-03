<!DOCTYPE html>
<html lang="fr">
  <head> 
      @include('admin.css')
      <title>@yield('title', 'Admin')</title>
      @yield('styles')
  </head>
  <body>
      @include('admin.header')
      @include('admin.sidebar')

      <div class="page-content">
          <div class="page-header">
              <div class="container-fluid">
                  @yield('content')
              </div>
          </div>
      </div>

      @include('admin.js')
  </body>
</html>
