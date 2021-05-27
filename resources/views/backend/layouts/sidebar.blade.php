<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Fournisseur -->
    <a class="sidebar-fournisseur d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <div class="sidebar-fournisseur-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-fournisseur-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('admin')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banner
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('file-manager')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Gestionnaire de médias</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-image"></i>
        <span>Bannières</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Bannière Options:</h6>
          <a class="collapse-item" href="{{route('banner.index')}}">Bannière</a>
          <a class="collapse-item" href="{{route('banner.create')}}">Ajouter Bannière</a>
        </div>
      </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
        Magasin
        </div>

    <!-- Categories -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true" aria-controls="categoryCollapse">
          <i class="fas fa-sitemap"></i>
          <span>Categorie</span>
        </a>
        <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Categorie Options:</h6>
            <a class="collapse-item" href="{{route('categorie.index')}}">Categorie</a>
            <a class="collapse-item" href="{{route('categorie.create')}}">Ajouter Categorie</a>
          </div>
        </div>
    </li>
    {{-- Materiels --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#materielCollapse" aria-expanded="true" aria-controls="materielCollapse">
          <i class="fas fa-cubes"></i>
          <span>Materiel</span>
        </a>
        <div id="materielCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Materiel Options:</h6>
            <a class="collapse-item" href="{{route('materiel.index')}}">Materiel</a>
            <a class="collapse-item" href="{{route('materiel.create')}}">Ajouter Materiel</a>
          </div>
        </div>
    </li>
    {{-- location --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#locationCollapse" aria-expanded="true" aria-controls="locationCollapse">
          <i class="fas fa-table"></i>
          <span>Location</span>
        </a>
        <div id="locationCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Location Options:</h6>
            <a class="collapse-item" href="{{route('location.index')}}">Afficher location</a>
         
          </div>
        </div>
    </li>
    {{-- livreur --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#livreurCollapse" aria-expanded="true" aria-controls="locationCollapse">
          <i class="fas fa-table"></i>
          <span>Livreur</span>
        </a>
        <div id="livreurCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Livreur Options:</h6>
            <a class="collapse-item" href="{{route('livreur.index')}}">Afficher livreur</a>
            <a class="collapse-item" href="{{route('livreur.create')}}">Ajouter livreur</a>
          </div>
        </div>
    </li>

    {{-- Fournisseurs --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#fournisseurCollapse" aria-expanded="true" aria-controls="fournisseurCollapse">
          <i class="fas fa-table"></i>
          <span>Fournisseurs</span>
        </a>
        <div id="fournisseurCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Fournisseur Options:</h6>
            <a class="collapse-item" href="{{route('fournisseur.index')}}">Fournisseurs</a>
            <a class="collapse-item" href="{{route('fournisseur.create')}}">Ajouter Fournisseur</a>
          </div>
        </div>
    </li>

    {{-- Livraison --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#livraisonCollapse" aria-expanded="true" aria-controls="livraisonCollapse">
          <i class="fas fa-truck"></i>
          <span>Livraison</span>
        </a>
        <div id="livraisonCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Livraison Options:</h6>
            <a class="collapse-item" href="{{route('livraison.index')}}">Livraison</a>
            <a class="collapse-item" href="{{route('livraison.create')}}">Ajouter Livraison</a>
          </div>
        </div>
    </li>

    <!--Commandes -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('order.index')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Commandes</span>
        </a>
    </li>

    <!-- Aviss -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('review.index')}}">
            <i class="fas fa-comments"></i>
            <span>Avis</span></a>
    </li>
     <!-- Reclamations -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('backend.reclamtion.index')}}">
            <i class="fas fa-exclamation"></i>
            <span>Reclamations</span>
        </a>
    </li> 

    

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Poste
    </div>

    <!-- Posts -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCollapse" aria-expanded="true" aria-controls="postCollapse">
        <i class="fas fa-fw fa-folder"></i>
        <span>Poste</span>
      </a>
      <div id="postCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Poste Options:</h6>
          <a class="collapse-item" href="{{route('post.index')}}">Poste</a>
          <a class="collapse-item" href="{{route('post.create')}}">Ajouter Poste</a>
        </div>
      </div>
    </li>

     <!-- Categorie -->
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCategoryCollapse" aria-expanded="true" aria-controls="postCategoryCollapse">
          <i class="fas fa-sitemap fa-folder"></i>
          <span>Categorie</span>
        </a>
        <div id="postCategoryCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Categorie Options:</h6>
            <a class="collapse-item" href="{{route('post-categorie.index')}}">Categorie</a>
            <a class="collapse-item" href="{{route('post-categorie.create')}}">Ajouter Categorie</a>
          </div>
        </div>
      </li>

      <!-- Tags -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagCollapse" aria-expanded="true" aria-controls="tagCollapse">
            <i class="fas fa-tags fa-folder"></i>
            <span>Tags</span>
        </a>
        <div id="tagCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tag Options:</h6>
            <a class="collapse-item" href="{{route('post-tag.index')}}">Tag</a>
            <a class="collapse-item" href="{{route('post-tag.create')}}">Ajouter Tag</a>
            </div>
        </div>
    </li>

      <!-- Comments -->
      <li class="nav-item">
        <a class="nav-link" href="{{route('comment.index')}}">
            <i class="fas fa-comments fa-chart-area"></i>
            <span>Commentaires</span>
        </a>
      </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
     <!-- Heading -->
    <div class="sidebar-heading">
       Parametres general
    </div>
    <li class="nav-item">
      <a class="nav-link" href="{{route('coupon.index')}}">
          <i class="fas fa-table"></i>
          <span>Coupon</span></a>
    </li>
     <!-- Users -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('users.index')}}">
            <i class="fas fa-users"></i>
            <span>Utilisateur</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('excel.index')}}">
        <i class="far fa-file-excel"></i>
            <span>Model Excel</span></a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>