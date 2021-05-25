@extends('backend.layouts.master')
@section('title','EDM-Medical || Fournisseur Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Modifier Fournisseur</h5>
    <div class="card-body">
      <form method="post" action="{{route('fournisseur.update',$fournisseur->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputnom" class="col-form-label">Nom</label>
        <input id="inputnom" type="text" name="nom" placeholder="Enter nom"  value="{{$fournisseur->nom}}" class="form-control" >
        @error('nom')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputtelephone" class="col-form-label">Telephone </label>
        <input id="inputtelephone" type="text" name="telephone" placeholder="Enter telephone"  value="{{$fournisseur->telephone}}" class="form-control">
        @error('telephone')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputadresse" class="col-form-label">Adresse </label>
        <input id="inputadresse" type="text" name="adresse" placeholder="Enter adresse"  value="{{$fournisseur->adresse}}" class="form-control">
        @error('adresse')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputemail" class="col-form-label">Email </label>
        <input id="inputemail" type="text" name="email" placeholder="Enter title"  value="{{$fournisseur->email}}" class="form-control">
        @error('email')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputdescription" class="col-form-label">Description</label>
        <input id="inputTitle" type="text" name="description" placeholder="Enter description"  value="{{$fournisseur->description}}" class="form-control">
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>    
        <div class="form-group">
          <label for="status" class="col-form-label">Statut <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($fournisseur->status=='active') ? 'selected' : '')}}>Activer</option>
            <option value="inactive" {{(($fournisseur->status=='inactive') ? 'selected' : '')}}>Désactiver</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Modifier</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush