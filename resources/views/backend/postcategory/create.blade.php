@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Ajouter  Categorie  de Poste</h5>
    <div class="card-body">
      <form method="post" action="{{route('post-categorie.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Titre</label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter titre"  value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Statut</label>
          <select name="status" class="form-control">
              <option value="active">Activer</option>
              <option value="inactive">Desactiver</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Initialiser</button>
           <button class="btn btn-success" type="submit">Valider</button>
        </div>
      </form>
    </div>
</div>

@endsection
