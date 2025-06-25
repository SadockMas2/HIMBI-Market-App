 <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="admin/img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">SAIDI MASUDI</h1>
            <p>Web Designer</p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">ADMIN</span>
        <ul class="list-unstyled">


               <li class="active">
                  <a href="{{ url('home') }}">
                    <i class="fa fa-home"></i> Accueil
                  </a>
               </li>

            <li>
                <a href="#dropdownUtilisateurs" aria-expanded="false" data-toggle="collapse">
                  <i class="fa fa-user"></i> Utilisateurs
                </a>
                <ul id="dropdownUtilisateurs" class="collapse list-unstyled">
                  <li><a href="{{ url('show_user') }}">Utilisateurs enregistrés</a></li>
                  <li><a href="{{ url('add_serveur') }}">Ajouter un serveur</a></li>
                  <li><a href="{{ url('view_serveur') }}">Voir les serveurs</a></li>
                </ul>
            </li>




             <li>
                <a href="#dropdownPlats" aria-expanded="false" data-toggle="collapse">
                  <i class="fa fa-cutlery"></i> Plats
                </a>
                <ul id="dropdownPlats" class="collapse list-unstyled">
                  <li><a href="{{ url('add_food') }}">Ajouter un plat</a></li>
                  <li><a href="{{ url('view_food') }}">Voir les plats</a></li>
                </ul>
              </li>

            
              <li>
               <li>
             <li>
                <a href="#dropdownTables" aria-expanded="false" data-toggle="collapse">
                  <i class="fa fa-chair"></i> Tables
                </a>
                <ul id="dropdownTables" class="collapse list-unstyled">
                  <li><a href="{{ url('add_table') }}">Ajouter une Table</a></li>
                  <li><a href="{{ url('view_table') }}">Tables disponibles</a></li>
                </ul>
              </li>


                <li>
                  <a href="{{ url('orders') }}"> <i 
                  class="fa fa-shopping-cart"></i>Panier
                  </a>               
                </li>

                <li>
                  <a href="{{ url('reservations') }}"> <i 
                  <i class="fa fa-list-alt"></i>Reservations
                  </a>               
                </li>

                
                <li>
                  <a href="{{ url('stock') }}"> <i 
                  <i class="fa fa-list-alt"></i>Stock
                  </a>               
                </li>

                
                <li>
                  <a href="{{ url('journal') }}"> <i 
                  <i class="fa fa-list-alt"></i>Journal des paiements
                  </a>               
                </li>

                
              

    
      </nav>
      <!-- Sidebar Navigation end-->