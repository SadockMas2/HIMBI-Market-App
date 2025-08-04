 <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="admin/img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">HIMBI Market</h1>
            <p>Admin</p>
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
                <a href="#dropdownTables" aria-expanded="false" data-toggle="collapse">
                 <i class="fa fa-chair"></i> Tables
                </a>
                <ul id="dropdownTables" class="collapse list-unstyled">
                  <li> <a href="{{ url('add_table') }}">Ajouter une table</a></li>
                  <li><a href="{{ url('view_table') }}">Gestion de tables</a></li>
                </ul>
              </li>


              

             @php
              $nb_alertes = \App\Models\Order::where('stock_insuffisant', true)->count();
            @endphp

            <li>
              <a href="#dropdownStock" aria-expanded="false" data-toggle="collapse">
                <i class="fa fa-boxes"></i> Stock
              </a>
              <ul id="dropdownStock" class="collapse list-unstyled">
                <li><a href="{{ url('show_stock') }}">Tous le stock</a></li>
                <li>
                  <a href="{{ url('alert_stock') }}">
                    Alertes
                    @if($nb_alertes > 0)
                      <span class="badge badge-danger">{{ $nb_alertes }}</span>
                    @endif
                  </a>
                </li>
              </ul>
            </li>

                


                <li>
                  <a href="{{ url('orders') }}"> <i 
                  class="fa fa-shopping-cart"></i>Paniers
                  </a>               
                </li>

                <li>
                  <a href="{{ url('reservations') }}"> <i 
                    class="fa fa-list-alt"></i>Reservations
                  </a>               
                </li>

                
               

                
                <li>
                    <a href="{{ url('historique') }}">
                        <i class="fa fa-history"></i> Paiements
                    </a>
                </li>

             


    
      </nav>
      <!-- Sidebar Navigation end-->