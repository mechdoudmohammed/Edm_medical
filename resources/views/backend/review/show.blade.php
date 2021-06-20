@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Commande       <a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  </h5>
  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>ID</th>
            <th>Commande n </th>
            <th>Nom</th>
            <th>Email</th>
            <th>Quantité</th>
            <th>Charge</th>
            <th>Totale</th>
            <th>Statut</th>
            <th>Operation</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->cart_id}}</td>
            <td>{{$order->first_name}} {{$order->last_name}}</td>
            <td>{{$order->email}}</td>
            <td>{{$order->quantity}}</td>
            <td>{{number_format($order->delivery_charge,2)}} Dhs</td>
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
            <td>
                <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                  @csrf 
                  @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Supprimer"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
          
        </tr>
      </tbody>
    </table>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">INFORMATION SUR LA COMMANDE</h4>
              <table class="table">
                    <tr class="">
                        <td>Numero de commande</td>
                        <td> : {{$order->cart_id}}</td>
                    </tr>
                    <tr>
                        <td>Date de commande</td>
                        <td> : {{$order->created_at->diffForHumans()}}</td>
                    </tr>
                    <tr>
                        <td>Quantité</td>
                        <td> : {{$order->quantity}}</td>
                    </tr>
                    <tr>
                        <td>Statut de commande</td>
                        <td> : {{$order->status}}</td>
                    </tr>
                    <tr>
                        <td>Charge de livraison </td>
                        <td> : {{number_format($order->delivery_charge,2)}} Dhs</td>
                    </tr>
                    <tr>
                        <td>Totale</td>
                        <td> : {{number_format($order->total_amount,2)}} Dhs</td>
                    </tr>
                    <tr>
                        <td>Methode de paiment</td>
                        <td> : </td>
                    </tr>
                    <tr>
                        <td>Statut de paiment</td>
                        <td> : </td>
                    </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="livraison-info">
              <h4 class="text-center pb-4"> INFORMATION DE LIVRAISON</h4>
              <table class="table">
                    <tr class="">
                        <td>Nom Complet</td>
                        <td> : {{$order->first_name}} {{$order->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$order->email}}</td>
                    </tr>
                    <tr>
                        <td>Tél</td>
                        <td> : {{$order->phone}}</td>
                    </tr>
                    <tr>
                        <td>Adresse</td>
                        <td> : {{$order->address1}}, {{$order->address2}}</td>
                    </tr>
                    <tr>
                        <td>ville</td>
                        <td> : {{$order->country}}</td>
                    </tr>
                    <tr>
                        <td>Code postale</td>
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