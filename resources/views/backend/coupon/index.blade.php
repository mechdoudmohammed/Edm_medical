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
      <h6 class="m-0 font-weight-bold text-primary float-left">Listes des Coupon</h6>
      <a href="{{route('coupon.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Ajouter Coupon</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($coupons)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Code Coupon </th>
              <th>Type</th>
              <th>Valeur</th>
              <th>Statut</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
            <th>ID</th>
              <th>Code Coupon </th>
              <th>Type</th>
              <th>Valeur</th>
              <th>Statut</th>
              <th>Operation</th>
              </tr>
          </tfoot>
          <tbody>
            @foreach($coupons as $coupon)   
                <tr>
                    <td>{{$coupon->id}}</td>
                    <td>{{$coupon->code}}</td>
                    <td>
                        @if($coupon->type=='fixed')
                            <span class="badge badge-primary">{{$coupon->type}}</span>
                        @else
                            <span class="badge badge-warning">{{$coupon->type}}</span>
                        @endif
                    </td>
                    <td>
                        @if($coupon->type=='fixed')
                           {{number_format($coupon->value,2)}} Dhs
                        @else
                            {{$coupon->value}}%
                        @endif</td>
                    <td>
                        @if($coupon->status=='active')
                            <span class="badge badge-success">{{$coupon->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$coupon->status}}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('coupon.edit',$coupon->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Modifier" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('coupon.destroy',[$coupon->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$coupon->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Suprimer"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                   
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$coupons->links()}}</span>
        @else
          <h6 class="text-center">Aucun coupon trouvé !!! Veuillez créer un coupon</h6>
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
        transform: scale(3.2);
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
      
      $('#banner-dataTable').DataTable( {
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
                    text: "l'enregistrement sera supprimé",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush