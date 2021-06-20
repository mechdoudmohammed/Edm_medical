@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('user.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Listes des commandes de location</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders)>0)
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>N° Commande</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Date Debut</th>
              <th>Date Fin</th>
              <th>Duree</th>
              <th>Quantité</th>
              <th>Prix</th>
              <th>Statut</th>
              <th>Operation</th>

            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>N° Commande</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Date Debut</th>
              <th>Date Fin</th>
              <th>Duree</th>
              <th>Quantité</th>
              <th>Prix</th>
              <th>Statut</th>
              <th>Operation</th>
              </tr>
          </tfoot>
          <tbody>
            @foreach($orders as $order)  
            @php
                $reclamations=DB::table('reclamations')->where('id_order',$order->id)->get();
                $livraison_charge=DB::table('livraisons')->where('id',$order->livraison_id)->pluck('price');
            @endphp  
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->order_number}}</td>
                    <td>{{$order->first_name}} {{$order->last_name}}</td>
                    <td>{{$order->email}}</td>
                    <td>{{$order->date_debut}}</td>
                    <td>{{$order->date_fin}}</td>
                    <td>{{$order->duree}} jours</td>
                    <td>{{$order->quantite}}</td>                   
                    <td>{{number_format($order->total_amount,2)}} Dhs</td>
                    <td>
                        @if($order->status=='new')
                          <span class="badge badge-primary">{{$order->status}}</span>
                        @elseif($order->status=='process')
                          <span class="badge badge-warning">{{$order->status}}</span>
                        @elseif($order->status=='delivered')
                          <span class="badge badge-success">{{$order->status}}</span>
                        @else
                          <span class="badge badge-danger">{{$order->status}}</span>
                        @endif

                        @if(count($reclamations)>0 )
                        @foreach($reclamations as $reclamation)
                        <span class="badge badge-dark">Reclamation {{$reclamation->statut}}</span>
                        @endforeach
                       @endif
                    </td>
                    <td style="display:flex;"> 
                    
                        <a href="{{route('user.location.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a> </br>
                        @if(count($reclamations)==0)
                        <a href="{{route('user.reclamationloc.create',$order->id)}}" class="btn btn-info btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="reclamer" data-placement="bottom"><i class="fas fa-exclamation"></i></a> </br> 
                       @endif
                        <form method="POST" action="{{route('user.location.delete',[$order->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$orders->links()}}</span>
        @else
          <h6 class="text-center">Aucune Commande de location trouvée </h6>
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
      
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[5,6]
                }
            ],
            "oLanguage": {
              "sSearch": "Chercher:",
            "sInfo":"Afficher _START_ à _END_ dans _TOTAL_ enregistrements",
            "sInfoEmpty":"Afficher 0 à 0 dans 0 enregistrements",
            "sLengthMenu":"Afficher _MENU_ enregistrements",
            "sZeroRecords":"Rien à afficher",
            "sEmptyTable":"Rien à afficher",
}
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
                    text: "Une fois supprimées, vous ne pourrez plus récupérer ces données!",
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