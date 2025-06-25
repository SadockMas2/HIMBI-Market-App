 <header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="search-panel">
          <div class="search-inner d-flex align-items-center justify-content-center">
            <div class="close-btn">Close <i class="fa fa-close"></i></div>
            <form id="searchForm" action="#">
              <div class="form-group">
                <input type="search" name="search" placeholder="What are you searching for...">
                <button type="submit" class="submit">Search</button>
              </div>
            </form>
          </div>
        </div>
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            
            <!-- Navbar Header--><a href="#" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase">
                <strong class="text-primary">HIMBI-</strong><strong>Market</strong></div>
              <div class="brand-text brand-sm">
                <strong class="text-primary">H</strong><strong>M</strong></div></a>
            
            
                <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>
          
            <!-- Log out               -->
            <div class="list-inline-item logout">                  

                            
                     
                    <form action="{{route('logout')}}" method="POST">
                                @csrf
                            <input class= "btn btn-primary ml-xl-4"
                             type="submit" value="Deconnecter">
                    </form>

            </div>
          </div>
        </div>
      </nav>
    </header>