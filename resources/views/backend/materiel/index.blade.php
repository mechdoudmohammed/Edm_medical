@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Liste materiel</h6>
      <a href="{{route('materiel.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Ajouter materiel"><i class="fas fa-plus"></i> Ajouter Materiel</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($materiels)>0)
        <table class="table table-bordered" id="materiel-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Fiche Technique</th>
              <th>Nom</th>
              <th>Categorie</th>
              <th>Est présenté</th>
              <th>Prix</th>
              <th>Réduction</th>
              <th>Condition</th>
              <th>Fournisseur</th>
              <th>Stock</th>
              <th>Statut</th>
              <th>Prix Location</th>
              <th>Location</th>
              <th>Opération</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Fiche Technique</th>
              <th>Nom</th>
              <th>Categorie</th>
              <th>Est présenté</th>
              <th>Prix</th>
              <th>Réduction</th>
              <th>Condition</th>
              <th>Fournisseur</th>
              <th>Stock</th>
              <th>Statut</th>
              <th>Location</th>
              <th>Prix Location</th>
              <th>Opération</th>
            </tr>
          </tfoot>
          <tbody>

            @foreach($materiels as $materiel)
              @php
              $sub_cat_info=DB::table('categories')->select('title')->where('id',$materiel->child_cat_id)->get();
              // dd($sub_cat_info);
              $fournisseurs=DB::table('fournisseurs')->select('nom')->where('id',$materiel->fournisseur_id)->get();
            @endphp
                <tr>
                    <td>{{$materiel->id}}</td>
                    <td>
                        @if($materiel->photo)
                            @php
                              $photo=explode(',',$materiel->photo);
                              // dd($photo);
                            @endphp
                            <img src="..\backend\img\materiels\{{$photo[0]}}" class="img-fluid zoom" style="max-width:80px" alt="{{$materiel->photo}}">
                        @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                        @endif
                    </td>
                    <td><a href="..\backend\fiches_techniques\{{$materiel->fiche_technique}}">fiche technique</a></td>
                    <td>{{$materiel->nom}}</td>
                    <td>{{$materiel->cat_info['title']}}
                      <sub>
                        @foreach($sub_cat_info as $data)
                          {{$data->title}}
                        @endforeach
                      </sub>
                    </td>
                    <td>{{(($materiel->is_featured==1)? 'Oui': 'Non')}}</td>
                    <td>{{$materiel->price}}</td>
                    <td>  {{$materiel->discount}}%</td>
                    <td>{{$materiel->condition}}</td>
                    <td>@foreach($fournisseurs as $fournisseur) {{$fournisseur->nom}} @endforeach</td>
                    <td>
                      @if($materiel->stock>0)
                      <span class="badge badge-primary">{{$materiel->stock}}</span>
                      @else
                      <span class="badge badge-danger">{{$materiel->stock}}</span>
                      @endif
                    </td>
                    <td>
                        @if($materiel->status=='active')
                            <span class="badge badge-success">{{$materiel->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$materiel->status}}</span>
                        @endif
                    </td>
                    <td>{{$materiel->prix_location}}</td>
                    <td>{{(($materiel->Location==1)? 'oui':'no')}}</td>
                    <td>
                        <a href="{{route('materiel.edit',$materiel->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('materiel.destroy',[$materiel->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$materiel->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Supprimer"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                  
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$materiels->links()}}</span>
        @else
          <h6 class="text-center">Aucun matériel trouvé !!! Veuillez créer du matériel</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#materiel-dataTable').DataTable( {
        "scrollX": false
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[10,11,12]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Êtes-vous sûr?",
                    text: "l'enregistrement sera supprimé",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Vos données sont en sécurité!");
                    }
                });
          })
      })
  </script>
@endpush
