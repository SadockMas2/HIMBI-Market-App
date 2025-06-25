<!DOCTYPE html>
<html>
  <head> 

 
       @include('admin.css')

  </head>
  <body>
   
        @include('admin.header')

        @include('admin.sidebar')



      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
              
            <h2>Ajouter un nouveau serveur</h2>

              @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              <form method="POST" action="{{ url('/add_serveur') }}">
                  @csrf

                  <div class="form-group">
                      <label>Nom :</label>
                      <input type="text" name="name" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label>Email :</label>
                      <input type="email" name="email" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label>Téléphone :</label>
                      <input type="text" name="phone" class="form-control">
                  </div>

                  <div class="form-group">
                      <label>Adresse :</label>
                      <input type="text" name="adress" class="form-control">
                  </div>

                  <div class="form-group">
                      <label>Mot de passe :</label>
                      <input type="password" name="password" class="form-control" required>
                  </div>

                  <input type="hidden" name="usertype" value="serveur">

                  <button type="submit" class="btn btn-primary">Ajouter</button>
              </form>
          </div>


          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
  </body>
</html>