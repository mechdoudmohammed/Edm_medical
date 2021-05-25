<!DOCTYPE html>
<html>
<head>
  <title>Commande @if($order)- {{$order->order_number}} @endif</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

@if($order)
<style type="text/css">
  .invoice-header {
    background: #f7f7f7;
    padding: 10px 20px 10px 20px;
    border-bottom: 1px solid gray;
  }
  .site-logo {
    margin-top: 20px;
  }
  .invoice-right-top h3 {
    padding-right: 20px;
    margin-top: 20px;
    color: green;
    font-size: 30px!important;
    font-family: serif;
  }
  .invoice-left-top {
    border-left: 4px solid green;
    padding-left: 20px;
    padding-top: 20px;
  }
  .invoice-left-top p {
    margin: 0;
    line-height: 20px;
    font-size: 16px;
    margin-bottom: 3px;
  }
  thead {
    background: green;
    color: #FFF;
  }
  .authority h5 {
    margin-top: -10px;
    color: green;
  }
  .thanks h4 {
    color: green;
    font-size: 25px;
    font-weight: normal;
    font-family: serif;
    margin-top: 20px;
  }
  .site-address p {
    line-height: 6px;
    font-weight: 300;
  }
  .table tfoot .empty {
    border: none;
  }
  .table-bordered {
    border: none;
  }
  .table-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125);
  }
  .table td, .table th {
    padding: .30rem;
  }
</style>
  <div class="invoice-header">
    <div class="float-left site-logo">
      <img src="{{asset('backend/img/logo.png')}}" alt="">
    </div>
    <div class="float-right site-address">
      <p>{{env('APP_ADDRESS')}}</p>
      <h3>Commande N: #{{$order->order_number}}</h3>

     
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="invoice-description">
    <div class="invoice-left-top float-left">
      <h6>Facture pour :</h6>
       <h3>{{$order->first_name}} {{$order->last_name}}</h3>
       <div class="address">
        <p>
          <strong>Pays: </strong>
          {{$order->country}}
        </p>
        <p>
          <strong>Adresse: </strong>
          {{ $order->address1 }} OR {{ $order->address2}}
        </p>
         <p><strong>Tél:</strong> {{ $order->phone }}</p>
         <p><strong>Email:</strong> {{ $order->email }}</p>
       </div>
    </div>
    <div class="invoice-right-top float-right" class="text-right">
    <?php  \Carbon\Carbon::setToStringFormat('d-m-Y H:i:s');
    ?>
      <p>Le :{{ $order->created_at->format('d/m/Y') }}</p>
      {{-- <img class="img-responsive" src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(150)->generate(route('admin.materiel.order.show', $order->id )))}}"> --}}
    </div>
    <div class="clearfix"></div>
  </div>
  <section class="order_details pt-3">
    <div class="table-header">
      <h5>details commande :</h5>
    </div>
    <table class="table table-bordered table-stripe">
      <thead>
        <tr>
          <th scope="col" class="col-6">Materiel</th>
          <th scope="col" class="col-3">Quantité</th>
          <th scope="col" class="col-3">Prix</th>
        </tr>
      </thead>
      <tbody>
      @foreach($order->cart_info as $cart)
      @php
        $materiel=DB::table('materiels')->select('nom')->where('id',$cart->materiel_id)->get();
      @endphp
        <tr>
          <td><span>
              @foreach($materiel as $pro)
                {{$pro->nom}}
              @endforeach
            </span></td>
          <td>x{{$cart->quantity}}</td>
          

          <td><span>{{number_format($cart->price,2)}}  Dhs</span></td>
        </tr>
      @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th scope="col" class="empty"></th>
          <th scope="col" class="text-right">Sous-total:</th>
          <th scope="col"> <span>{{number_format($order->sub_total,2)}}  Dhs</span></th>
        </tr>
    
        {{-- @if(!empty($order->coupon))
        <tr>
          <th scope="col" class="empty"></th>
          <th scope="col" class="text-right">Réduction:</th>
          <th scope="col"><span>-{{$order->coupon->discount(Helper::orderPrice($order->id, $order->user->id))}}{{Helper::base_currency()}}</span></th>
        </tr>
      @endif --}}



      <tr>
          <th scope="col" class="empty"></th>
          <th scope="col" class="text-right">TVA:</th>
          <th scope="col"> <span>20%</span></th>
        </tr>
        <tr>
          <th scope="col" class="empty"></th>
          <th scope="col" class="text-right">Frais livraison:</th>
          <th scope="col"> <span>
     @php

            $orders = DB::table('orders')
            ->join('livraisons', 'orders.livraison_id', '=', 'livraisons.id')
            ->select('livraisons.price')->distinct()
            ->get()
@endphp
            @foreach($orders as $ord)
                {{$ord->price}}
              @endforeach

               Dhs </span></th>
        </tr>




        <tr>
          <th scope="col" class="empty"></th>          
          <th scope="col" class="text-right">Total:</th>
          <th>
            <span>
               <?php
               $total=$order->total_amount+($order->total_amount*0.2);
              
               ?> 
               {{number_format($total,2)}}  Dhs
            </span>
          </th>
        </tr>



      </tfoot>
    </table>
  </section>
  <div class="thanks mt-3">
    <h4>Merci pour votre achat !!</h4>
  </div>
  <div class="authority float-right mt-5">
    <p>-----------------------------------</p>
    <h5>Signature:</h5>
  </div>
  <div class="clearfix"></div>
@else
  <h5 class="text-danger">Invalide</h5>
@endif
</body>
</html>
