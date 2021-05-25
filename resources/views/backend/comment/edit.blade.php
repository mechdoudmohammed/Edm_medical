@extends('backend.layouts.master')

@section('title','Modifier Commentaire')

@section('main-content')
<div class="card">
  <h5 class="card-header">Modifier Commentaire</h5>
  <div class="card-body">
    <form action="{{route('comment.update',$comment->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="name">Par :</label>
        <input type="text" disabled class="form-control" value="{{$comment->user_info->name}}">
      </div>
      <div class="form-group">
        <label for="comment">Commentaire :</label>
      <textarea name="comment" id="" cols="20" rows="10" class="form-control">{{$comment->comment}}</textarea>
      </div>
      <div class="form-group">
        <label for="status">Statut :</label>
        <select name="status" id="" class="form-control">
          <option value="">--Select Status--</option>
          <option value="active" {{(($comment->status=='active')? 'selected' : '')}}>Activer</option>
          <option value="inactive" {{(($comment->status=='inactive')? 'selected' : '')}}>Désactiver</option>
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