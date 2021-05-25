@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Liste de Reclamations</h6>
    </div>
       @php
          $reclamations=DB::table('reclamations')->where('id_user',auth()->user()->id)->get();
          
      @endphp
    <div class="card-body">
      <div class="table-responsive">
       @if(count($reclamations)>0)
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>id</th>
              <th>N° d'order</th>
              <th>Type</th>
              <th>message</th>
              <th>Date</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>id</th>
              <th>N° d'order</th>
              <th>Type</th>
              <th>message</th>
              <th>Date</th>
              <th>Statut</th>
              </tr>
          </tfoot>
          <tbody>
            @foreach($reclamations as $reclamation)  
            @php
              $orders=DB::table('orders')->where('id',$reclamation->id_order)->get();
            @endphp
            @foreach($orders as $order) 
                <tr>
                    <td>EDM{{$reclamation->id}}</td>
                    <td>{{$order->order_number}}</td>
                    <td>{{$reclamation->type_reclamation}}</td>
                    <td>
                    @if( $reclamation->msg_reclamation== null)
                    Sans message  
                    @else
                      {{$reclamation->msg_reclamation}}
                    @endif                  
                    </td>
                    <td>{{$reclamation->created_at}}</td>
                    <td>
                    @if(count($reclamations)>0 )
                        @foreach($reclamations as $reclamation)
                        <span class="badge badge-dark">Reclamation {{$reclamation->statut}}</span>
                        @endforeach
                       @endif
                       </td>
                </tr>  
            @endforeach
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">Il n'y pas de reclamations</h6>
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
                    text: "Once deleted, you will not be able to recover this data!",
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