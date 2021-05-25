<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Fournisseur -->
    <a class="sidebar-fournisseur d-flex align-items-center justify-content-center" href="{{route('user')}}">
      <div class="sidebar-fournisseur-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-fournisseur-text mx-3">Utilisateur</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Tableau de bord -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('user')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Magasin
        </div>
    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.order.index')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Commandes</span>
        </a>
    </li>

    <!-- Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.materielreview.index')}}">
            <i class="fas fa-comments"></i>
            <span>Avis</span></a>
    </li>

     <!--reclamations -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('user.reclamation.index')}}">
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
    <!-- Comments -->
    <li class="nav-item">
      <a class="nav-link" href="{{route('user.post-comment.index')}}">
          <i class="fas fa-comments fa-chart-area"></i>
          <span>Commentaires</span>
      </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>