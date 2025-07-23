<!DOCTYPE html>
<html>

<style>
/* Fixer la navbar en haut */
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1030; /* au-dessus de tout */
}

/* Fixer la sidebar sur la gauche */
#sidebar {
    position: fixed;
    top: 70px; /* hauteur de la navbar */
    left: 0;
    height: calc(100vh - 70px); /* hauteur totale moins la navbar */
    width: 250px;
    overflow-y: auto;
    z-index: 1020;
}

/* Ajuster le contenu principal pour qu’il ne soit pas caché */
.page-content {
    margin-left: 250px; /* largeur de la sidebar */
    padding-top: 80px; /* hauteur de la navbar */
    padding-right: 20px;
    padding-left: 20px;
}
</style>
  
  <head> 

 
       @include('admin.css')

  </head>
  <body>
   
        @include('admin.header')

        @include('admin.sidebar')



      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">

            @include('admin.body')

          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
  </body>
</html>