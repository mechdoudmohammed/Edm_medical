@if(session('Succès'))
    <div class="alert alert-success alert-dismissable fade show">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        {{session('Succès')}}
    </div>
@endif



@if(session('erreur'))
    <div class="alert alert-danger alert-dismissable fade show">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        {{session('erreur')}}
    </div>
@endif