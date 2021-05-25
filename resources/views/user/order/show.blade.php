@extends('user.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Order<a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  </h5>
  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>Id</th>
            <th>Commande N</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Statut</th>
        </tr>
      </thead>
      <tbody>
        <tr>

            <td>{{$order->id}}</td>
            <td>{{$order->order_number}}</td>
            <td>{{$order->first_name}} {{$order->last_name}}</td>
            <td>{{$order->email}}</td>
            <td>{{$order->quantity}}</td>

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
            </td>


        </tr>
      </tbody>
    </table>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">COMMANDE INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Commande N</td>
                        <td> : {{$order->order_number}}</td>
                    </tr>
                    <tr>
                        <td>Date commande</td>
                        <td> : {{$order->created_at->format('d-M-Y')}} {{$order->created_at->format('g : i a')}} </td>
                    </tr>
                    <tr>
                        <td>Quantité</td>
                        <td> : {{$order->quantity}}</td>
                    </tr>
                    <tr>
                        <td>Commande Statut</td>
                        <td> : {{$order->status}}</td>
                    </tr>

                    <tr>
                        <td>Total</td>
                        <td> : {{number_format($order->total_amount,2)}} Dhs</td>
                    </tr>
                    <tr>
                      <td>Mode de payment</td>
                      <td> : @if($order->payment_method=='cod') Cash on Delivery @else Paypal @endif</td>
                    </tr>
                    <tr>
                        <td>Payment Statut</td>
                        <td> : {{$order->payment_status}}</td>
                    </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="livraison-info">
              <h4 class="text-center pb-4">LIVRAISON INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Nom et Prenom</td>
                        <td> :  {{$order->last_name}} {{$order->first_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$order->email}}</td>
                    </tr>
                    <tr>
                        <td>Telephone</td>
                        <td> : {{$order->phone}}</td>
                    </tr>
                    <tr>
                        <td>Adress</td>
                        <td> : {{$order->address1}}, {{$order->address2}}</td>
                    </tr>
                    <tr>
                        <td>Ville</td>
                        <td> : {{$order->country}}</td>
                    </tr>
                    <tr>
                        <td>Code Postal</td>
                        <td> : {{$order->post_code}}</td>
                    </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.livraison-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.livraison-info h4{
        text-decoration: underline;
    }

</style>
@endpush
