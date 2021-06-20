@extends('user.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Reclamation
  </h5>
  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>Id</th>
            <th>Location N</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Quantite</th>
            <th>Totale</th>
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
              <h4 class="text-center pb-4">Reclamation</h4>
              <form method="POST" action="{{route('reclamationloc.save',[$order->id])}}">
              @csrf

              <label >Type de reclamation: </label>
                        
                        <select name="type_reclamation"  style="padding: 4px;border: none;background: #1cc88a;color: white;    display: inline;">
                            <option value="retard" name="Retard">Retard de livraison</option>
                            <option value="endommage" name="endommage">Ne fonction pas</option>
                            <option value="defferent" name="defferent">Order Défferent</option>
                            <option value="autre" name="autre">Autre</option>
                        </select></br>                        
              <h6 style="text-align:center" >Message de reclamation</h6>
              <textarea maxlength="300" name="msg_reclamation" cols="40" rows="10" placeholder="Taper votre message de reclamation ici.."></textarea>
                    <input name="user_id" type="hidden" value="{{$order->user_id}}">
               <button type="submit"style="background: #d52a1a;color: white;border-radius: 10px;padding: 5px;margin-left: 216px;margin-top: 10px;border: none;">Envoyer Reclamation</button> 

              </form>
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

textarea, select {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

    .col-lg-6 {
        margin: 0 auto;
    }
    .order-info{
      background: #f7f7f7;
    padding: 20px;
    border-radius: 16px;
    }
    .order-info h4{
        text-decoration: underline;
    }
</style>
@endpush
