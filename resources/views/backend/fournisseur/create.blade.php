@extends('backend.layouts.master')
@section('title','EDM-Medical || Fournisseur Create')
@section('main-content')

<div class="card">
    <h5 class="card-header">Ajouter Fournisseur</h5>
    <div class="card-body">
      <form method="post" action="{{route('fournisseur.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputnom" class="col-form-label">Nom <span class="text-danger">*</span></label>
        <input id="inputnom" type="text" name="nom" placeholder="Enter nom"  value="{{old('nom')}}" class="form-control" require>
        @error('nom')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputtelephone" class="col-form-label">Telephone <span class="text-danger">*</span></label>
        <input id="inputtelephone" type="text" name="telephone" placeholder="Enter telephone"  value="{{old('telephone')}}" class="form-control" require>
        @error('telephone')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputadresse" class="col-form-label">Adresse <span class="text-danger">*</span></label>
        <input id="inputadresse" type="text" name="adresse" placeholder="Enter adresse"  value="{{old('adresse')}}" class="form-control"require>
        @error('adresse')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputemail" class="col-form-label">Email <span class="text-danger">*</span></label>
        <input id="inputemail" type="text" name="email" placeholder="Entrer titre"  value="{{old('email')}}" class="form-control" require>
        @error('email')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="inputdescription" class="col-form-label">Description</label>
        <input id="inputTitle" type="text" name="description" placeholder="Enter description"  value="{{old('description')}}" class="form-control">
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Statut <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Activer</option>
              <option value="inactive">D??sactiver</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Initialiser</button>
           <button class="btn btn-success" type="submit">Ajouter</button>
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