@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header"> Modifier commande</h5>
  <div class="card-body">
    <form action="{{route('location.update',$order->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="status">Statut :</label>
        <select name="status" id="" class="form-control">
          <option value="">--Selectionner Statut--</option>
          <option value="new" {{(($order->status=='new')? 'selected' : '')}}>Nouveau</option>
          <option value="process" {{(($order->status=='process')? 'selected' : '')}}>traitement</option>
          <option value="delivered" {{(($order->status=='delivered')? 'selected' : '')}}>Livré</option>
          <option value="cancel" {{(($order->status=='cancel')? 'selected' : '')}}>Annuler</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
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